    <style>

        body {
            margin:                      0;
            font-family: Arial, sans-serif;
            box-sizing:         border-box;
            font-size:                18px;

        }

        footer{
            background: linear-gradient(135deg, #51e070, #009774);
            display:                                             flex;
            flex-direction:                                    column;
            gap:                                                 10px;
            align-items:                                       center;
            justify-content:                                   center;
            padding:                                             30px;
            width:                                               100%;
            box-sizing:                                    border-box;
            color:                                             #fff;
            margin-top:                                          auto;
            @media (max-width: 1104px){
                gap: 5px;
            }
        }

        footer p {
            text-align: center;
        }

        #redes a{
            color: #fff;
            font-size: 25px;
        }
        .footLinks{
            display:    flex;
            font-size:  16px ;
            @media (max-width: 600px){
                font-size:  12px ;
            }
        }
        .footLinks a{
            text-decoration:         none;
            color:                 #fff;
            display:                flex;
            justify-content:       center;
            align-items:           center;
            padding:                 2px 5px;
            box-sizing:         border-box;
            transition:     all 0.3s ease;

        }


    </style>


        <footer>
            <p>© 2026 U.E. Santo Domingo de Guzmán. Todos los derechos reservados.</p>
            <p><small>Pagina desarrollada por: UPTTMBI</small></p>
            <p><small>Programadores:- David Méndez - Javier López - Juan Jerez</small></p>
            
            <div id="redes">
                <a href="https://github.com/crichopia/U.E_Sto_Domingo_Anuncios-gestion_biblioteca" target="_blank" rel="noopener noreferrer">
                    <i class="fa-brands fa-github"></i>
                </a>
            </div>
            <div class="footLinks">
                <a href="/dashboards/newsDashboard.php">Noticias</a>
                <a href="/dashboards/bibliotecaDashboard.php">Biblioteca</a>
                <a href="/dashboards/recomenacionesDashboard.php">Recomendaciones</a>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' || isset($_SESSION['role']) && $_SESSION['role'] === 'bibliotecario') { ?>
                <a href="/adminDashboards/loansDashboard.php">Prestamos</a>
                <?php } ?>
                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') { ?>
                <a href="/adminDashboards/registerDashboard.php">Usuarios</a>
                <?php } ?>
            </div>

        </footer>
