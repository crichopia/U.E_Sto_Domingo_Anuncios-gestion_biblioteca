<?php
if (!isset($conn)) {
    require_once __DIR__ . '/../config/db.php';
}

$landingAnnouncements = $conn->query(
    'SELECT title, content, announcement_date, importance FROM announcements ORDER BY id DESC LIMIT 3'
)->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
    #main.landing-main {
        display: block;
        min-height: 0;
        padding: 0;
        background: #f8f8f3;
    }

    .school-home {
        --school-green: #176b4c;
        --school-green-dark: #104d3a;
        --school-gold: #d4a94d;
        --school-ink: #20352d;
        --school-muted: #68766e;
        overflow: hidden;
        color: var(--school-ink);
        background: #f8f8f3;
        font-family: "Segoe UI", Arial, sans-serif;
    }

    .school-home *,
    .school-home *::before,
    .school-home *::after {
        box-sizing: border-box;
    }

    .home-hero {
        position: relative;
        display: grid;
        grid-template-columns: minmax(0, 1.05fr) minmax(320px, .95fr);
        align-items: center;
        gap: 48px;
        min-height: 560px;
        padding: 72px max(7vw, calc((100vw - 1200px) / 2));
        color: #fff;
        background:
            radial-gradient(ellipse at 12% 8%, rgba(118, 166, 111, .25), transparent 34%),
            linear-gradient(120deg, #104d3a 0%, #176b4c 62%, #27785a 100%);
        isolation: isolate;
    }

    .home-hero::before {
        position: absolute;
        z-index: -1;
        top: -190px;
        right: 34%;
        width: 490px;
        height: 490px;
        border: 1px solid rgba(255, 255, 255, .11);
        border-radius: 50%;
        content: "";
    }

    .home-hero::after {
        position: absolute;
        z-index: -1;
        right: -140px;
        bottom: -370px;
        width: 650px;
        height: 650px;
        border: 1px solid rgba(255, 255, 255, .1);
        border-radius: 50%;
        content: "";
    }

    .home-hero__content {
        max-width: 590px;
        padding-bottom: 14px;
    }

    .home-eyebrow,
    .home-kicker {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: var(--school-gold);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: .15em;
        line-height: 1.5;
        text-transform: uppercase;
    }

    .home-eyebrow > span {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: var(--school-gold);
        box-shadow: 0 0 0 5px rgba(212, 169, 77, .16);
    }

    .home-hero h1 {
        margin: 22px 0 18px;
        color: #fff;
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(42px, 5.1vw, 68px);
        font-weight: 500;
        letter-spacing: -.045em;
        line-height: 1.06;
    }

    .home-hero h1 span {
        color: #e8c978;
        font-style: italic;
    }

    .home-hero__content > p {
        max-width: 500px;
        margin: 0;
        color: rgba(255, 255, 255, .79);
        font-size: 16px;
        line-height: 1.8;
    }

    .home-hero__actions {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 13px;
        margin-top: 30px;
    }

    .home-button {
        display: inline-flex;
        min-height: 48px;
        align-items: center;
        justify-content: center;
        gap: 11px;
        padding: 0 20px;
        border: 1px solid transparent;
        border-radius: 4px;
        font-size: 13px;
        font-weight: 750;
        text-align: center;
        text-decoration: none;
        transition: transform .2s ease, background-color .2s ease, color .2s ease;
    }

    .home-button:hover {
        transform: translateY(-2px);
    }

    .home-button--light {
        color: var(--school-green-dark);
        background: #fff;
    }

    .home-button--light:hover {
        color: #fff;
        background: var(--school-green-dark);
    }

    .home-button--outline {
        border-color: rgba(255, 255, 255, .45);
        color: #fff;
        background: transparent;
    }

    .home-button--outline:hover {
        border-color: #fff;
        color: var(--school-green-dark);
        background: #fff;
    }

    .home-hero__note {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-top: 32px;
        color: rgba(255, 255, 255, .68);
        font-size: 12px;
    }

    .home-hero__note i {
        color: #e8c978;
    }

    .home-hero__visual {
        position: relative;
        width: 100%;
        max-width: 485px;
        min-height: 360px;
        justify-self: end;
    }

    .home-hero__photo {
        position: absolute;
        inset: 0 12px 18px 24px;
        overflow: hidden;
        border: 7px solid rgba(255, 255, 255, .12);
        border-radius: 48% 48% 5px 5px;
        background:
            linear-gradient(180deg, rgba(20, 55, 41, .08), rgba(20, 55, 41, .25)),
            url("https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=1100&q=85") center 42% / cover,
            #9ab69b;
        box-shadow: 0 22px 55px rgba(5, 34, 24, .25);
    }

    .home-hero__seal {
        position: absolute;
        right: -4px;
        bottom: 23px;
        display: flex;
        width: 190px;
        min-height: 92px;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border: 1px solid #eee6d3;
        border-radius: 5px;
        color: var(--school-ink);
        background: #fffdf8;
        box-shadow: 0 14px 34px rgba(5, 34, 24, .18);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 13px;
        line-height: 1.45;
    }

    .home-hero__seal img {
        width: 53px;
        height: 64px;
        object-fit: contain;
    }

    .home-hero__seal strong {
        color: var(--school-green);
    }

    .home-hero__since {
        position: absolute;
        top: 48px;
        left: 0;
        display: flex;
        width: 113px;
        height: 113px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        border: 1px solid rgba(255, 255, 255, .42);
        border-radius: 50%;
        color: #fff;
        background: rgba(17, 77, 57, .88);
        text-align: center;
        box-shadow: 0 10px 25px rgba(5, 34, 24, .2);
    }

    .home-hero__since strong {
        color: #e8c978;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 25px;
    }

    .home-hero__since span {
        margin-top: 2px;
        font-size: 10px;
        line-height: 1.35;
    }

    .home-scroll {
        position: absolute;
        bottom: 20px;
        left: 50%;
        display: grid;
        width: 34px;
        height: 34px;
        place-items: center;
        border: 1px solid rgba(255, 255, 255, .32);
        border-radius: 50%;
        color: #fff;
        font-size: 12px;
        text-decoration: none;
    }

    .home-welcome {
        padding: 88px max(7vw, calc((100vw - 1200px) / 2)) 92px;
        background:
            radial-gradient(circle at 12% 10%, rgba(23, 107, 76, .055) 0 1px, transparent 1.5px) 0 0 / 15px 15px,
            #fbfaf6;
    }

    .home-section-heading {
        max-width: 670px;
        margin: 0 auto 43px;
        text-align: center;
    }

    .home-kicker {
        color: var(--school-green);
    }

    .home-section-heading h2,
    .home-news__intro h2,
    .home-library h2 {
        margin: 11px 0 12px;
        color: var(--school-ink);
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(31px, 3.5vw, 44px);
        font-weight: 500;
        letter-spacing: -.035em;
        line-height: 1.18;
    }

    .home-section-heading h2 span,
    .home-news__intro h2 span {
        color: var(--school-green);
        font-style: italic;
    }

    .home-section-heading > p,
    .home-news__intro > p {
        margin: 0;
        color: var(--school-muted);
        font-size: 14px;
        line-height: 1.8;
    }

    .home-pillars {
        display: grid;
        max-width: 1100px;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin: 0 auto;
    }

    .home-pillar {
        position: relative;
        min-height: 228px;
        padding: 25px 24px 24px;
        border: 1px solid #e8e8df;
        border-radius: 5px;
        background: rgba(255, 255, 255, .83);
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .home-pillar:hover {
        transform: translateY(-4px);
        box-shadow: 0 14px 30px rgba(30, 60, 43, .08);
    }

    .home-pillar__icon {
        display: grid;
        width: 46px;
        height: 46px;
        place-items: center;
        border-radius: 50%;
        font-size: 18px;
    }

    .home-pillar__icon--green {
        color: #176b4c;
        background: #e9f3eb;
    }

    .home-pillar__icon--gold {
        color: #a8781e;
        background: #f8f0dd;
    }

    .home-pillar__icon--blue {
        color: #40657a;
        background: #e9f0f2;
    }

    .home-pillar__number {
        position: absolute;
        top: 30px;
        right: 24px;
        color: #c5c9bd;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 14px;
    }

    .home-pillar h3 {
        margin: 22px 0 8px;
        color: var(--school-ink);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 19px;
        font-weight: 600;
    }

    .home-pillar p {
        margin: 0;
        color: var(--school-muted);
        font-size: 13px;
        line-height: 1.75;
    }

    .home-news {
        display: grid;
        grid-template-columns: minmax(220px, .72fr) minmax(0, 1.28fr);
        gap: 72px;
        padding: 77px max(7vw, calc((100vw - 1200px) / 2));
        background: #eef2e9;
    }

    .home-news__intro {
        align-self: start;
        padding-top: 15px;
    }

    .home-news__intro h2 {
        margin-top: 13px;
        font-size: clamp(32px, 3.2vw, 42px);
    }

    .home-text-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-top: 23px;
        color: var(--school-green);
        font-size: 13px;
        font-weight: 750;
        text-decoration: none;
    }

    .home-text-link:hover {
        color: var(--school-green-dark);
    }

    .home-news__list {
        display: grid;
        gap: 11px;
    }

    .home-news-card {
        display: grid;
        grid-template-columns: 42px minmax(0, 1fr) 18px;
        align-items: start;
        gap: 15px;
        padding: 18px 20px;
        border: 1px solid #e3e8dc;
        border-radius: 4px;
        background: #fff;
    }

    .home-news-card__icon {
        display: grid;
        width: 38px;
        height: 38px;
        place-items: center;
        border-radius: 50%;
        color: var(--school-green);
        background: #edf5ee;
    }

    .home-news-card__meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 10px;
        color: #8a938c;
        font-size: 10px;
    }

    .home-news-card__tag {
        padding: 4px 8px;
        border-radius: 20px;
        color: #497253;
        background: #edf5ee;
        font-size: 9px;
        font-weight: 750;
        text-transform: uppercase;
    }

    .home-news-card__tag--importante {
        color: #91651c;
        background: #fbf2df;
    }

    .home-news-card__tag--urgente {
        color: #a7463b;
        background: #f9e9e6;
    }

    .home-news-card h3 {
        margin: 7px 0 4px;
        color: var(--school-ink);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 17px;
        font-weight: 600;
    }

    .home-news-card p {
        display: -webkit-box;
        overflow: hidden;
        margin: 0;
        color: var(--school-muted);
        font-size: 12px;
        line-height: 1.65;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 2;
    }

    .home-news-card__arrow {
        padding-top: 4px;
        color: #9ba49b;
        font-size: 12px;
    }

    .home-news-empty {
        padding: 32px;
        border: 1px dashed #cdd8ca;
        border-radius: 4px;
        background: rgba(255, 255, 255, .65);
        text-align: center;
    }

    .home-news-empty > span {
        color: var(--school-green);
        font-size: 23px;
    }

    .home-news-empty h3 {
        margin: 12px 0 5px;
        color: var(--school-ink);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 19px;
    }

    .home-news-empty p {
        margin: 0;
        color: var(--school-muted);
        font-size: 13px;
    }

    .home-library {
        position: relative;
        display: flex;
        min-height: 205px;
        align-items: center;
        gap: 25px;
        overflow: hidden;
        padding: 43px max(7vw, calc((100vw - 1200px) / 2));
        color: #fff;
        background: var(--school-green-dark);
    }

    .home-library__icon {
        display: grid;
        width: 66px;
        height: 66px;
        flex: 0 0 66px;
        place-items: center;
        border: 1px solid rgba(255, 255, 255, .25);
        border-radius: 50%;
        color: #e8c978;
        font-size: 25px;
    }

    .home-library__copy {
        position: relative;
        z-index: 1;
        max-width: 570px;
        margin-right: auto;
    }

    .home-library .home-kicker {
        color: #e8c978;
    }

    .home-library h2 {
        margin: 8px 0 7px;
        color: #fff;
        font-size: clamp(25px, 3vw, 35px);
    }

    .home-library__copy p {
        margin: 0;
        color: rgba(255, 255, 255, .72);
        font-size: 13px;
        line-height: 1.7;
    }

    .home-button--dark {
        position: relative;
        z-index: 1;
        flex: 0 0 auto;
        color: var(--school-green-dark);
        background: #e8c978;
    }

    .home-button--dark:hover {
        background: #f1d997;
    }

    .home-library__decoration {
        position: absolute;
        right: 4%;
        bottom: -66px;
        color: rgba(255, 255, 255, .045);
        font-family: Georgia, "Times New Roman", serif;
        font-size: 230px;
        font-weight: 700;
        pointer-events: none;
    }

    .home-quote {
        display: flex;
        min-height: 230px;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 45px 24px;
        background: #fbfaf6;
        text-align: center;
    }

    .home-quote__mark {
        height: 36px;
        color: #d7b15b;
        font-family: Georgia, "Times New Roman", serif;
        font-size: 65px;
        line-height: 1;
    }

    .home-quote > p {
        max-width: 700px;
        margin: 12px 0;
        color: var(--school-ink);
        font-family: Georgia, "Times New Roman", serif;
        font-size: clamp(20px, 2.6vw, 29px);
        font-style: italic;
        line-height: 1.45;
    }

    .home-quote__caption {
        color: var(--school-green);
        font-size: 10px;
        font-weight: 750;
        letter-spacing: .12em;
        text-transform: uppercase;
    }

    @media (max-width: 850px) {
        .home-hero {
            grid-template-columns: minmax(0, 1fr) minmax(260px, .8fr);
            gap: 24px;
            min-height: 500px;
            padding: 58px 6vw;
        }

        .home-hero__visual {
            min-height: 310px;
        }

        .home-news {
            gap: 35px;
            padding-right: 6vw;
            padding-left: 6vw;
        }

        .home-welcome {
            padding-right: 6vw;
            padding-left: 6vw;
        }

        .home-library {
            padding-right: 6vw;
            padding-left: 6vw;
        }
    }

    @media (max-width: 640px) {
        .home-hero {
            grid-template-columns: 1fr;
            gap: 28px;
            padding: 55px 7vw 70px;
        }

        .home-hero h1 {
            font-size: clamp(42px, 12vw, 58px);
        }

        .home-hero__content > p {
            font-size: 14px;
        }

        .home-hero__visual {
            width: min(100%, 410px);
            min-height: 300px;
            justify-self: center;
        }

        .home-hero__photo {
            inset: 0 20px 12px 25px;
        }

        .home-hero__since {
            top: 25px;
            left: 0;
            width: 94px;
            height: 94px;
        }

        .home-hero__seal {
            right: 0;
            bottom: 15px;
        }

        .home-scroll {
            display: none;
        }

        .home-welcome {
            padding: 62px 7vw;
        }

        .home-section-heading {
            margin-bottom: 28px;
        }

        .home-pillars {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .home-pillar {
            min-height: auto;
            padding: 21px;
        }

        .home-pillar h3 {
            margin-top: 15px;
        }

        .home-news {
            grid-template-columns: 1fr;
            gap: 27px;
            padding: 56px 7vw;
        }

        .home-news__intro {
            padding-top: 0;
        }

        .home-news-card {
            grid-template-columns: 34px minmax(0, 1fr);
            gap: 11px;
            padding: 15px 13px;
        }

        .home-news-card__icon {
            width: 32px;
            height: 32px;
            font-size: 13px;
        }

        .home-news-card__arrow {
            display: none;
        }

        .home-library {
            flex-wrap: wrap;
            gap: 17px;
            padding: 39px 7vw;
        }

        .home-library__icon {
            width: 52px;
            height: 52px;
            flex-basis: 52px;
            font-size: 19px;
        }

        .home-library__copy {
            width: calc(100% - 70px);
        }

        .home-library .home-button {
            margin-left: 69px;
        }

        .home-quote {
            min-height: 200px;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .home-button,
        .home-pillar {
            transition: none;
        }
    }
</style>

<div class="school-home">
    <section class="home-hero" aria-labelledby="home-title">
        <div class="home-hero__content">
            <span class="home-eyebrow"><span aria-hidden="true"></span> Unidad Educativa · Fundada en 1958</span>
            <h1 id="home-title">Aprender hoy.<br><span>Transformar mañana.</span></h1>
            <p>En la Unidad Educativa Santo Domingo de Guzmán acompañamos a cada estudiante a descubrir su potencial y construir un futuro con valores.</p>
            <div class="home-hero__actions">
                <a class="home-button home-button--light" href="/dashboards/newsDashboard.php">
                    Conoce nuestras noticias <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                </a>
                <a class="home-button home-button--outline" href="#nuestra-comunidad">Conócenos</a>
            </div>
            <div class="home-hero__note"><i class="fa-solid fa-book-open" aria-hidden="true"></i> Una comunidad que aprende, crece y comparte</div>
        </div>
        <div class="home-hero__visual" role="img" aria-label="Estudiantes aprendiendo en el aula">
            <div class="home-hero__photo"></div>
            <div class="home-hero__seal">
                <img src="/assets/logo_stoDomingo.png" alt="Escudo de la Unidad Educativa Santo Domingo de Guzmán">
                <span>Educamos con<br><strong>fe y propósito</strong></span>
            </div>
            <div class="home-hero__since"><strong>1958</strong><span>formando<br>generaciones</span></div>
        </div>
        <a class="home-scroll" href="#nuestra-comunidad" aria-label="Desplazarse a nuestra comunidad"><i class="fa-solid fa-arrow-down" aria-hidden="true"></i></a>
    </section>

    <section class="home-welcome" id="nuestra-comunidad" aria-labelledby="welcome-title">
        <div class="home-section-heading">
            <span class="home-kicker">Bienvenidos a casa</span>
            <h2 id="welcome-title">Una escuela para <span>crecer juntos</span></h2>
            <p>Formamos personas íntegras en un ambiente cercano, inspirador y comprometido con el aprendizaje de cada estudiante.</p>
        </div>
        <div class="home-pillars">
            <article class="home-pillar">
                <span class="home-pillar__icon home-pillar__icon--green"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></span>
                <span class="home-pillar__number">01</span>
                <h3>Aprendizaje con propósito</h3>
                <p>Despertamos la curiosidad y acompañamos el desarrollo de habilidades para la vida.</p>
            </article>
            <article class="home-pillar">
                <span class="home-pillar__icon home-pillar__icon--gold"><i class="fa-solid fa-heart" aria-hidden="true"></i></span>
                <span class="home-pillar__number">02</span>
                <h3>Valores que nos unen</h3>
                <p>Promovemos el respeto, la solidaridad y la responsabilidad dentro y fuera del aula.</p>
            </article>
            <article class="home-pillar">
                <span class="home-pillar__icon home-pillar__icon--blue"><i class="fa-solid fa-people-group" aria-hidden="true"></i></span>
                <span class="home-pillar__number">03</span>
                <h3>Una comunidad cercana</h3>
                <p>Familias, docentes y estudiantes construimos juntos una experiencia educativa significativa.</p>
            </article>
        </div>
    </section>

    <section class="home-news" aria-labelledby="news-title">
        <div class="home-news__intro">
            <span class="home-kicker">Lo que pasa en la escuela</span>
            <h2 id="news-title">Noticias y <span>avisos</span></h2>
            <p>Mantente al día con las novedades de nuestra comunidad educativa.</p>
            <a class="home-text-link" href="/dashboards/newsDashboard.php">
                Ver todos los anuncios <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
            </a>
        </div>
        <div class="home-news__list">
            <?php if ($landingAnnouncements) { ?>
                <?php foreach ($landingAnnouncements as $announcement) { ?>
                    <?php
                    $importance = in_array($announcement['importance'], ['normal', 'importante', 'urgente'], true)
                        ? $announcement['importance']
                        : 'normal';
                    ?>
                    <article class="home-news-card">
                        <span class="home-news-card__icon"><i class="fa-regular fa-bell" aria-hidden="true"></i></span>
                        <div class="home-news-card__body">
                            <div class="home-news-card__meta">
                                <time><?php echo htmlspecialchars($announcement['announcement_date'], ENT_QUOTES, 'UTF-8'); ?></time>
                                <span class="home-news-card__tag home-news-card__tag--<?php echo htmlspecialchars($importance, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars(ucfirst($importance), ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </div>
                            <h3><?php echo htmlspecialchars($announcement['title'], ENT_QUOTES, 'UTF-8'); ?></h3>
                            <p><?php echo htmlspecialchars($announcement['content'], ENT_QUOTES, 'UTF-8'); ?></p>
                        </div>
                        <i class="fa-solid fa-arrow-up-right-from-square home-news-card__arrow" aria-hidden="true"></i>
                    </article>
                <?php } ?>
            <?php } else { ?>
                <div class="home-news-empty">
                    <span><i class="fa-regular fa-calendar" aria-hidden="true"></i></span>
                    <h3>Pronto habrá novedades</h3>
                    <p>Cuando publiquemos nuevos avisos, los encontrarás aquí.</p>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="home-library" aria-labelledby="library-title">
        <div class="home-library__icon"><i class="fa-solid fa-book-open-reader" aria-hidden="true"></i></div>
        <div class="home-library__copy">
            <span class="home-kicker">Un mundo por descubrir</span>
            <h2 id="library-title">La lectura abre nuevas puertas.</h2>
            <p>Explora el catálogo de nuestra biblioteca y encuentra tu próxima gran historia.</p>
        </div>
        <a class="home-button home-button--dark" href="/dashboards/bibliotecaDashboard.php">
            Explorar biblioteca <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
        </a>
        <span class="home-library__decoration" aria-hidden="true">Aa</span>
    </section>

    <section class="home-quote" aria-label="Nuestra misión">
        <span class="home-quote__mark" aria-hidden="true">“</span>
        <p>Educar es sembrar en cada estudiante la confianza para llegar tan lejos como sus sueños.</p>
        <span class="home-quote__caption">Unidad Educativa Santo Domingo de Guzmán</span>
    </section>
</div>