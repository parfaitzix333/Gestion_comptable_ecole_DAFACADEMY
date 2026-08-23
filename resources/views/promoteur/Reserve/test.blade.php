<!-- Zone à imprimer -->
<div class="zoneAimprimer" id="zoneAimprimer{{ $p->id }}">

    <div id="EnteteFacture" class="d-flex items-justify-content">

        <img src="{{ asset('image/logo.jpeg') }}" alt="factureLogo" width="60px" height="60px"
            class="rounded-5 border border-2 border-primary">

        <div class="d-block text-center">

            <h1 class="text-danger fw-bold">
                DAF ACADEMY
            </h1>

            <h4>
                <b>INSTITUTION SCOLAIRE BILINGUE</b>
            </h4>

            <h4>
                (Français-Anglais)
            </h4>

            <h5>
                SECTION:
                {{ $p->classe->section->designation ?? '--' }}
            </h5>

            <h2>
                Année scolaire :
                {{ $p->anneeScolaire->annee ?? '--' }}
            </h2>
            <div class="text-danger border border-2 border-danger"></div>
            div

        </div>

    </div>

</div>



<style>
    /* =====================================
     À L'ÉCRAN
     ===================================== */

    .zoneAimprimer {
        display: none;
    }

    /* =====================================
  À L'IMPRESSION
 ===================================== */

    @page {
        size: A4 portrait;
        margin: 10mm;
    }

    @media print {

        /* On cache toute la page */
        body * {
            visibility: hidden !important;
        }

        /* On affiche uniquement notre zone */
        .zoneAimprimer,
        .zoneAimprimer * {
            visibility: visible !important;
        }

        /* On positionne la zone au début de la page */
        .zoneAimprimer {
            display: block !important;

            position: absolute;
            top: 0;
            left: 0;

            width: 190mm;
            min-height: 277mm;

            padding: 10mm;

            background: white !important;
            color: black !important;

            box-sizing: border-box;
        }

    }
</style>
