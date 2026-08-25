@extends('base.base_promoteur')
@section('content')
    @include('promoteur._shared_styles')

    <div class="content-wrapper">
        <div class="page-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="fas fa-address-book"></i> Contacts</h2>
                    <p>Gérez les coordonnées de contact</p>
                </div>
                <div>
                    <button class="btn-modern btn-primary-modern" data-bs-toggle="modal"
                        data-bs-target="#createContactModal"><i class="fas fa-plus-circle"></i> Nouveau Contact</button>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-modern alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-modern alert-danger">{{ session('error') }}</div>
        @endif

        <div class="table-wrapper">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#ID</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nos_contacts as $c)
                        <tr>
                            <td class="fw-bold text-primary">#{{ $c->id }}</td>
                            <td>{{ $c->couriel }}</td>
                            <td>{{ $c->tel }}</td>
                            <td>{{ $c->latitude }}</td>
                            <td>{{ $c->longitude }}</td>
                            <td>{{ $c->adresse }}</td>
                            <td>
                                <div class="action-buttons">
                                    <button class="btn-icon btn-edit" data-bs-toggle="modal"
                                        data-bs-target="#editContactModal{{ $c->id }}"><i
                                            class="fas fa-edit"></i></button>
                                    <form action="{{ route('contacts.destroy', $c->id) }}" method="POST"
                                        onsubmit="return confirmDelete(event)">@csrf @method('DELETE')<button
                                            class="btn-icon btn-delete"><i class="fas fa-trash-alt"></i></button></form>
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade modal-modern" id="editContactModal{{ $c->id }}" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Modifier Contact</h5><button class="btn-close"
                                            data-bs-dismiss="modal"></button>
                                    </div>
                                    <form action="{{ route('contacts.update', $c->id) }}" method="POST">@csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="form-group"><label class="form-label">Email</label><input
                                                    name="couriel" class="form-control-modern" value="{{ $c->couriel }}"
                                                    required></div>
                                            <div class="form-group"><label class="form-label">Téléphone</label><input
                                                    name="tel" class="form-control-modern" value="{{ $c->tel }}">
                                            </div>
                                            <div class="form-group"><label class="form-label">Adresse</label><input
                                                    name="adresse" class="form-control-modern" value="{{ $c->adresse }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Latitude</label>
                                                <input type="numeric" name="latitude" class="form-control-modern"
                                                    id="latitude" placeholder="-11.12345...." value="{{ $c->latitude }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">Longitude</label>
                                                <input type="numeric" class="form-control-modern" name="longitude"
                                                    id="longitude" placeholder="27.113524..." value="{{ $c->longitude }}">
                                            </div>
                                        </div>
                                        <div class="modal-footer"><button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Annuler</button><button
                                                class="btn-submit">Enregistrer</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="empty-state"><i class="fas fa-address-book"></i>
                                    <h4>Aucun contact</h4>
                                    <p>Ajoutez des coordonnées utiles</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade modal-modern" id="createContactModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nouveau Contact</h5><button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('contacts.store') }}" method="POST">@csrf
                    <div class="modal-body">
                        <div class="form-group"><label class="form-label">Email</label><input name="couriel"
                                class="form-control-modern" required></div>
                        <div class="form-group"><label class="form-label">Téléphone</label><input name="tel"
                                class="form-control-modern"></div>
                        <div class="form-group">
                            <label class="form-label">Adresse</label>
                            <input name="adresse" class="form-control-modern">
                        </div>

                        <div class="form-group">
                            <label class="form-label">Latitude</label>
                            <input type="numeric" name="latitude" class="form-control-modern" id="latitude"
                                placeholder="-11.12345....">
                        </div>
                        <div class="form-group">
                            <label class="form-label">Longitude</label>
                            <input type="numeric" class="form-control-modern" name="longitude" id="longitude"
                                placeholder="27.113524...">
                        </div>

                    </div>
                    <div class="modal-footer"><button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Annuler</button><button class="btn-submit">Créer</button></div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(e) {
            e.preventDefault();
            if (confirm('Confirmer la suppression ?')) e.target.submit();
            return false;
        }
    </script>
    <script>
        // ============================================
        // GÉOLOCALISATION AVEC ADRESSE FORMATÉE
        // ============================================

        document.addEventListener('DOMContentLoaded', function() {

            // Sélecteurs
            const getLocationBtn = document.getElementById('getLocationBtn');
            const locationStatus = document.getElementById('locationStatus');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const adresseInput = document.querySelector('input[name="adresse"]');

            /**
             * Récupère la position actuelle
             */
            function getCurrentPosition() {
                if (!navigator.geolocation) {
                    updateStatus('error', '❌ La géolocalisation n\'est pas supportée.');
                    return;
                }

                updateStatus('loading', '⏳ Récupération de votre position...');
                getLocationBtn.disabled = true;
                getLocationBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Récupération...';

                navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;

                        latitudeInput.value = lat;
                        longitudeInput.value = lng;

                        const accuracy = Math.round(position.coords.accuracy);
                        updateStatus('success',
                            `✅ Position enregistrée (${lat.toFixed(6)}, ${lng.toFixed(6)}) - précision : ${accuracy} m`
                        );

                        // Récupérer l'adresse formatée
                        getFormattedAddress(lat, lng);

                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML =
                            '<i class="fas fa-location-crosshairs"></i> Utiliser ma position actuelle';

                        // Animation
                        highlightField(latitudeInput);
                        highlightField(longitudeInput);
                    },
                    function(error) {
                        handleError(error);
                        getLocationBtn.disabled = false;
                        getLocationBtn.innerHTML =
                            '<i class="fas fa-location-crosshairs"></i> Utiliser ma position actuelle';
                    }, {
                        enableHighAccuracy: true,
                        timeout: 15000
                    }
                );
            }

            /**
             * Récupère et formate l'adresse à partir des coordonnées
             * Version avec formatage personnalisé
             */
            function getFormattedAddress(lat, lng) {
                if (!adresseInput) return;

                const url = new URL('https://nominatim.openstreetmap.org/reverse');
                url.search = new URLSearchParams({
                    lat: lat.toString(),
                    lon: lng.toString(),
                    format: 'jsonv2',
                    'accept-language': 'fr',
                    zoom: '18',
                    addressdetails: '1'
                });

                fetch(url.toString(), {
                        headers: {
                            Accept: 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        if (!data || !data.display_name) {
                            throw new Error('Adresse introuvable');
                        }

                        // display_name est l'adresse complète renvoyée par Nominatim.
                        adresseInput.value = data.display_name;
                        updateStatus('success',
                            `📍 Adresse trouvée. Les coordonnées GPS restent la référence exacte.`);
                        highlightField(adresseInput);
                    })
                    .catch(error => {
                        console.log('Erreur reverse geocoding:', error);
                        updateStatus('warning', '⚠️ Position récupérée mais adresse non disponible.');
                    });
            }

            /**
             * Version alternative avec Google Maps API (plus précise)
             * Décommentez et ajoutez votre clé API
             */
            function getAddressWithGoogle(lat, lng) {
                // const apiKey = 'VOTRE_CLE_GOOGLE_MAPS_API';
                // const url = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${lat},${lng}&key=${apiKey}&language=fr`;
                //
                // fetch(url)
                //     .then(response => response.json())
                //     .then(data => {
                //         if (data.status === 'OK' && data.results.length > 0) {
                //             // Utiliser l'adresse formatée par Google
                //             const formattedAddress = data.results[0].formatted_address;
                //             adresseInput.value = formattedAddress;
                //             updateStatus('success', `📍 ${formattedAddress.split(',').slice(0, 3).join(',')}`);
                //         }
                //     })
                //     .catch(error => console.log(error));
            }

            /**
             * Met en évidence un champ
             */
            function highlightField(field) {
                if (!field) return;
                field.classList.add('highlight-field');
                setTimeout(() => {
                    field.classList.remove('highlight-field');
                }, 2000);
            }

            /**
             * Met à jour le statut
             */
            function updateStatus(type, message) {
                if (!locationStatus) return;

                const colors = {
                    loading: '#0d6efd',
                    success: '#198754',
                    error: '#dc3545',
                    warning: '#ffc107',
                    info: '#0dcaf0'
                };

                const icons = {
                    loading: '<i class="fas fa-spinner fa-spin me-1"></i>',
                    success: '<i class="fas fa-check-circle me-1 text-success"></i>',
                    error: '<i class="fas fa-exclamation-circle me-1 text-danger"></i>',
                    warning: '<i class="fas fa-exclamation-triangle me-1 text-warning"></i>',
                    info: '<i class="fas fa-info-circle me-1 text-info"></i>'
                };

                locationStatus.innerHTML = (icons[type] || '') + ' ' + message;
                locationStatus.style.color = colors[type] || '#6c757d';
            }

            /**
             * Gère les erreurs
             */
            function handleError(error) {
                let message = '';
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        message = '⚠️ Permission refusée. Autorisez la géolocalisation dans les paramètres.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        message = '📍 Position non disponible. Activez votre GPS ou Wi-Fi.';
                        break;
                    case error.TIMEOUT:
                        message = '⏱️ Délai dépassé. Réessayez dans un endroit dégagé.';
                        break;
                    default:
                        message = `❌ ${error.message}`;
                }
                updateStatus('error', message);
            }

            // ============================================
            // ÉVÉNEMENTS
            // ============================================

            if (getLocationBtn) {
                getLocationBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    getCurrentPosition();
                });
            }

            // Raccourci clavier
            document.addEventListener('keydown', function(e) {
                if (e.ctrlKey && e.shiftKey && e.key === 'G') {
                    e.preventDefault();
                    if (getLocationBtn) getLocationBtn.click();
                }
            });

            // Vérification de compatibilité
            if (!navigator.geolocation && locationStatus) {
                locationStatus.innerHTML = '⚠️ La géolocalisation n\'est pas disponible.';
                locationStatus.style.color = '#dc3545';
                if (getLocationBtn) getLocationBtn.disabled = true;
            }
        });
    </script>
@endsection
