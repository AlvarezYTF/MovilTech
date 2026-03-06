<script src="https://cdn.jsdelivr.net/npm/qz-tray@2.2.4/qz-tray.js"></script>
<script>
(function () {
    if (window.__repairsQzTicketPrinterLoaded) {
        return;
    }

    window.__repairsQzTicketPrinterLoaded = true;
    const qzSecurityEnabled = @json((bool) config('printing.qz.enabled', false));
    const qzSignatureAlgorithm = @json((string) config('printing.qz.signature_algorithm', 'SHA512'));
    const qzCertificateUrl = @json(route('qz.certificate'));
    const qzSignUrl = @json(route('qz.sign'));
    let qzSecurityConfigured = false;

    function setButtonsState(repairId, isPrinting) {
        document.querySelectorAll('[data-ticket-repair-id="' + repairId + '"]').forEach(function (button) {
            button.disabled = isPrinting;
            button.classList.toggle('opacity-60', isPrinting);
            button.classList.toggle('cursor-not-allowed', isPrinting);
        });
    }

    async function parseResponseError(response, fallbackMessage) {
        const contentType = (response.headers.get('content-type') || '').toLowerCase();

        if (contentType.includes('application/json')) {
            const body = await response.json().catch(function () {
                return {};
            });
            if (typeof body.message === 'string' && body.message.trim() !== '') {
                return body.message.trim();
            }
        }

        const text = await response.text().catch(function () {
            return '';
        });

        return text.trim() || fallbackMessage;
    }

    function buildFriendlyMessage(error) {
        const rawMessage = (error && error.message ? String(error.message) : '').trim();
        const normalized = rawMessage.toLowerCase();

        if (normalized.includes('libreria qz')) {
            return 'No se pudo iniciar QZ Tray en el navegador. Recarga la pagina e intenta nuevamente.';
        }

        if (normalized.includes('certificado de qz') || normalized.includes('firmar la solicitud')) {
            return 'No se pudo validar la seguridad de impresion. Verifica la configuracion de certificado y firma en el servidor.';
        }

        if (normalized.includes('no hay impresoras disponibles')) {
            return 'No encontramos impresoras disponibles en este equipo. Verifica conexion USB/Bluetooth y drivers.';
        }

        if (normalized.includes('identificar automaticamente la impresora termica')) {
            return rawMessage + '\n\nSugerencia: configura QZ_DEFAULT_PRINTER con el nombre exacto de la impresora termica.';
        }

        if (normalized.includes('obtener los datos del ticket')) {
            return 'No se pudo preparar el ticket para imprimir. Recarga la pagina e intenta de nuevo.';
        }

        if (normalized.includes('websocket')) {
            return 'No hay conexion con QZ Tray. Asegurate de que QZ este abierto y autorizado.';
        }

        return rawMessage || 'Ocurrio un problema al imprimir. Intenta nuevamente.';
    }

    function configureQzSecurity() {
        if (!qzSecurityEnabled || qzSecurityConfigured) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        qz.security.setCertificatePromise(function (resolve, reject) {
            fetch(qzCertificateUrl, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'text/plain',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            })
                .then(async function (response) {
                    if (!response.ok) {
                        const message = await parseResponseError(response, 'No fue posible cargar el certificado de QZ Tray.');
                        throw new Error(message);
                    }

                    const certificate = await response.text();
                    if (!certificate.trim()) {
                        throw new Error('El certificado de QZ Tray esta vacio.');
                    }

                    resolve(certificate);
                })
                .catch(reject);
        });

        qz.security.setSignatureAlgorithm(qzSignatureAlgorithm || 'SHA512');
        qz.security.setSignaturePromise(function (toSign) {
            return function (resolve, reject) {
                fetch(qzSignUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify({ request: toSign }),
                })
                    .then(async function (response) {
                        const body = await response.json().catch(function () {
                            return {};
                        });

                        if (!response.ok) {
                            const message = body.message || 'No fue posible firmar la solicitud de QZ Tray.';
                            throw new Error(message);
                        }

                        if (!body.signature) {
                            throw new Error('La firma de QZ Tray no fue generada.');
                        }

                        resolve(body.signature);
                    })
                    .catch(reject);
            };
        });

        qzSecurityConfigured = true;
    }

    async function ensureQzConnection() {
        if (!window.qz) {
            throw new Error('No se pudo cargar la libreria QZ Tray.');
        }

        configureQzSecurity();

        if (qz.websocket.isActive()) {
            return;
        }

        await qz.websocket.connect({ retries: 3, delay: 1 });
    }

    async function resolvePrinter(preferredPrinter) {
        const printers = await qz.printers.find();
        if (!printers || !printers.length) {
            throw new Error('No hay impresoras disponibles en este equipo.');
        }

        const normalizedPreferred = (preferredPrinter || '').toLowerCase().trim();
        if (normalizedPreferred) {
            const exactMatch = printers.find(function (printerName) {
                return printerName.toLowerCase().trim() === normalizedPreferred;
            });

            if (exactMatch) {
                return exactMatch;
            }

            const partialMatch = printers.find(function (printerName) {
                return printerName.toLowerCase().includes(normalizedPreferred);
            });

            if (partialMatch) {
                return partialMatch;
            }
        }

        const virtualKeywords = [
            'microsoft print to pdf',
            'print to pdf',
            'pdf',
            'xps',
            'onenote',
            'fax',
        ];

        const physicalPrinters = printers.filter(function (printerName) {
            const normalized = printerName.toLowerCase();
            return !virtualKeywords.some(function (keyword) {
                return normalized.includes(keyword);
            });
        });

        const candidates = physicalPrinters.length ? physicalPrinters : printers;
        const thermalKeywords = ['mp80', 'thermal', 'receipt', 'pos', 'bluetooth', 'usb', 'xprinter', 'epson', 'tm-', '80mm'];
        const keywordMatch = candidates.find(function (printerName) {
            const normalized = printerName.toLowerCase();
            return thermalKeywords.some(function (keyword) {
                return normalized.includes(keyword);
            });
        });

        if (keywordMatch) {
            return keywordMatch;
        }

        if (candidates.length === 1) {
            return candidates[0];
        }

        throw new Error(
            'No se pudo identificar automaticamente la impresora termica. ' +
            'Configura QZ_DEFAULT_PRINTER con el nombre exacto. Disponibles: ' +
            candidates.join(', ')
        );
    }

    window.printRepairTicket = async function printRepairTicket(repairId) {
        const numericRepairId = Number(repairId);
        if (!Number.isFinite(numericRepairId)) {
            alert('No se pudo identificar la reparacion para impresion. Recarga la pagina e intenta nuevamente.');
            return;
        }

        setButtonsState(numericRepairId, true);

        try {
            await ensureQzConnection();

            const payloadResponse = await fetch(`{{ url('/repairs') }}/${numericRepairId}/ticket-payload`, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            if (!payloadResponse.ok) {
                throw new Error('No fue posible obtener los datos del ticket.');
            }

            const payload = await payloadResponse.json();
            const printerName = await resolvePrinter(payload.printer_hint);
            const config = qz.configs.create(printerName, {
                encoding: payload.encoding || 'CP437',
                copies: 1,
                jobName: payload.job_name || `repair-ticket-${numericRepairId}`,
            });

            await qz.print(config, payload.data || []);
            alert(`Listo. Ticket enviado correctamente a: ${printerName}`);
        } catch (error) {
            console.error('Repair ticket print error', error);
            alert(buildFriendlyMessage(error));
        } finally {
            setButtonsState(numericRepairId, false);
        }
    };
})();
</script>
