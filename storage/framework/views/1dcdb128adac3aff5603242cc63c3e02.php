<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>GoalTracker - Suivez vos objectifs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('images/hero-bg.jpg');
            background-size: cover;
            background-position: center;
            height: 100vh;
            display: flex;
            align-items: center;
            color: white;
        }
        .feature-card {
            transition: transform 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .feature-card:hover {
            transform: translateY(-10px);
        }
        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #0d6efd;
        }
        .testimonial-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .cta-section {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
            color: white;
            padding: 5rem 0;
        }
        .navbar {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        .btn-custom {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">GoalTracker</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Fonctionnalités</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Témoignages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary btn-custom">Connexion</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-custom">Inscription</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="display-3 fw-bold mb-4">Atteignez vos objectifs avec GoalTracker</h1>
                    <p class="lead mb-4">Suivez votre progression, partagez vos succès et restez motivé avec notre plateforme de suivi d'objectifs.</p>
                    <div class="d-flex gap-3">
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-lg btn-custom">Commencer gratuitement</a>
                        <a href="#features" class="btn btn-outline-light btn-lg btn-custom">En savoir plus</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-5">
        <div class="container">
            <h2 class="text-center mb-5">Fonctionnalités principales</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4 text-center">
                        <i class="fas fa-bullseye feature-icon"></i>
                        <h3>Suivi des objectifs</h3>
                        <p>Créez et suivez vos objectifs avec des étapes claires et une progression mesurable.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4 text-center">
                        <i class="fas fa-users feature-icon"></i>
                        <h3>Partage et collaboration</h3>
                        <p>Partagez vos objectifs avec vos amis et collaborez pour atteindre vos buts ensemble.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card h-100 p-4 text-center">
                        <i class="fas fa-chart-line feature-icon"></i>
                        <h3>Statistiques détaillées</h3>
                        <p>Visualisez votre progression avec des graphiques et des statistiques détaillées.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-5">Ce qu'en disent nos utilisateurs</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card testimonial-card p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="images/testimonial1.jpg" class="rounded-circle me-3" width="50" height="50" alt="User">
                            <div>
                                <h5 class="mb-0">Marie D.</h5>
                                <small class="text-muted">Entrepreneure</small>
                            </div>
                        </div>
                        <p class="mb-0">"GoalTracker m'a aidé à organiser mes objectifs professionnels et à suivre ma progression efficacement."</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="images/testimonial2.jpg" class="rounded-circle me-3" width="50" height="50" alt="User">
                            <div>
                                <h5 class="mb-0">Thomas L.</h5>
                                <small class="text-muted">Étudiant</small>
                            </div>
                        </div>
                        <p class="mb-0">"La fonction de partage m'a permis de travailler sur mes objectifs avec mes amis. C'est motivant !"</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card testimonial-card p-4">
                        <div class="d-flex align-items-center mb-3">
                            <img src="images/testimonial3.jpg" class="rounded-circle me-3" width="50" height="50" alt="User">
                            <div>
                                <h5 class="mb-0">Sophie M.</h5>
                                <small class="text-muted">Fitness Coach</small>
                            </div>
                        </div>
                        <p class="mb-0">"Les statistiques détaillées m'aident à suivre les progrès de mes clients et à les motiver."</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container text-center">
            <h2 class="display-4 mb-4">Prêt à commencer votre voyage ?</h2>
            <p class="lead mb-4">Rejoignez des milliers d'utilisateurs qui atteignent leurs objectifs avec GoalTracker.</p>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg btn-custom">S'inscrire gratuitement</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5>GoalTracker</h5>
                    <p>Votre partenaire pour atteindre vos objectifs.</p>
                </div>
                <div class="col-md-3">
                    <h5>Liens rapides</h5>
                    <ul class="list-unstyled">
                        <li><a href="#features" class="text-white">Fonctionnalités</a></li>
                        <li><a href="#testimonials" class="text-white">Témoignages</a></li>
                        <li><a href="#contact" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-envelope me-2"></i>contact@goaltracker.com</li>
                        <li><i class="fas fa-phone me-2"></i>+33 1 23 45 67 89</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo e(date('Y')); ?> GoalTracker. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Navbar background change on scroll
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                document.querySelector('.navbar').style.background = 'rgba(255, 255, 255, 0.95)';
            } else {
                document.querySelector('.navbar').style.background = 'rgba(255, 255, 255, 0.95)';
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\Nour_user\projetweb2\resources\views/welcome.blade.php ENDPATH**/ ?>