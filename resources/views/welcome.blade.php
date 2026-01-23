<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>NLLC</title>

        <link rel="icon" href="/image/logo.png" sizes="any">
        <link rel="apple-touch-icon" href="/image/logo.png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        <!-- Styles -->
        <style>
            * { margin: 0; padding: 0; box-sizing: border-box; }
            body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; line-height: 1.5; }
            .gradient-text { background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
            .btn-primary { display: inline-flex; align-items: center; gap: 0.5rem; padding: 1rem 2rem; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); color: white; border-radius: 9999px; font-weight: bold; text-decoration: none; transition: all 0.3s; cursor: pointer; border: none; }
            .btn-primary:hover { transform: scale(1.05); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
            .btn-secondary { display: inline-flex; align-items: center; gap: 0.5rem; padding: 1rem 2rem; border: 2px solid #3b82f6; color: #3b82f6; border-radius: 9999px; font-weight: bold; text-decoration: none; transition: all 0.3s; cursor: pointer; background: transparent; }
            .btn-secondary:hover { background: #eff6ff; }
            .card { background: white; border-radius: 1.5rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1); transition: all 0.3s; }
            .card:hover { box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); }
            .section { width: 100%; padding: 5rem 1.5rem; }
            .container { max-width: 80rem; margin: 0 auto; padding: 0 1.5rem; }
            nav { position: sticky; top: 0; z-index: 50; background: white; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); }
            nav .container { display: flex; align-items: center; justify-content: space-between; padding: 1rem 1.5rem; }
            .logo { display: flex; align-items: center; gap: 0.75rem; font-size: 2rem; }
            .logo h1 { font-size: 1.875rem; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
            .nav-links { display: flex; gap: 1rem; align-items: center; }
            
            /* Scroll Animation Styles */
            .fade-in { opacity: 0; transform: translateY(30px); transition: all 0.8s ease-out; }
            .fade-in.visible { opacity: 1; transform: translateY(0); }
            .fade-in-up { opacity: 0; transform: translateY(50px); transition: all 0.8s ease-out; }
            .fade-in-up.visible { opacity: 1; transform: translateY(0); }
            .slide-in-left { opacity: 0; transform: translateX(-50px); transition: all 0.8s ease-out; }
            .slide-in-left.visible { opacity: 1; transform: translateX(0); }
            .slide-in-right { opacity: 0; transform: translateX(50px); transition: all 0.8s ease-out; }
            .slide-in-right.visible { opacity: 1; transform: translateX(0); }
            .scale-in { opacity: 0; transform: scale(0.95); transition: all 0.8s ease-out; }
            .scale-in.visible { opacity: 1; transform: scale(1); }
            
            /* Mobile Responsive */
            @media (max-width: 1024px) {
                .hero-grid { grid-template-columns: 1fr !important; }
                .features-grid { grid-template-columns: repeat(2, 1fr) !important; }
                .learning-grid { grid-template-columns: repeat(3, 1fr) !important; }
            }
            
            @media (max-width: 768px) { 
                .nav-links { gap: 0.25rem; flex-wrap: wrap; } 
                .btn-primary, .btn-secondary { padding: 0.75rem 1rem; font-size: 0.875rem; } 
                .hero-title { font-size: 2rem !important; }
                .hero-subtitle { font-size: 1rem !important; }
                .features-grid { grid-template-columns: 1fr !important; }
                .learning-grid { grid-template-columns: repeat(2, 1fr) !important; }
                .stats-container { flex-direction: column; gap: 1.5rem !important; }
                .cta-title { font-size: 1.875rem !important; }
                .cta-subtitle { font-size: 1rem !important; }
            }
            
            @media (max-width: 640px) {
                .nav-links { gap: 0.25rem; }
                .btn-primary, .btn-secondary { padding: 0.625rem 0.75rem; font-size: 0.75rem; }
                .logo h1 { font-size: 1.5rem; }
                .hero-title { font-size: 1.5rem !important; }
                .hero-subtitle { font-size: 0.875rem !important; }
                .features-grid { grid-template-columns: 1fr !important; }
                .learning-grid { grid-template-columns: 1fr !important; }
                .stats-container { flex-direction: column; gap: 1rem !important; }
                .cta-title { font-size: 1.5rem !important; }
                .cta-subtitle { font-size: 0.875rem !important; }
                section { padding: 3rem 1rem !important; }
                .emoji-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 0.75rem !important; }
            }
        </style>
    </head>
    <body style="background: linear-gradient(135deg, #dbeafe 0%, #f3e8ff 100%); color: #111827; margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
        <!-- Navigation Header -->
        <nav style="position: sticky; top: 0; z-index: 50; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="max-width: 80rem; margin: 0 auto; padding: 0.75rem 1rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <img src="/image/logo.png" alt="BrighStar Logo" style="height: 2.5rem; width: auto;">
                    <h1 style="font-size: 1.5rem; margin: 0; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">NLLC</h1>
                </div>
                @if (Route::has('login'))
                    <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                        @auth
                            <a href="{{ url('/dashboard') }}" style="padding: 0.5rem 1rem; color: #374151; text-decoration: none; font-weight: 600; transition: color 0.3s; font-size: 0.875rem;">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" style="padding: 0.5rem 0.75rem; color: #374151; text-decoration: none; font-weight: 600; transition: color 0.3s; font-size: 0.75rem;">Log in</a>
                            <a href="{{ route('teachers.login') }}" style="padding: 0.5rem 0.75rem; color: #059669; text-decoration: none; font-weight: 600; transition: color 0.3s; border: 2px solid #059669; border-radius: 9999px; font-size: 0.75rem;">Teachers</a>
                            <a href="{{ route('parents.login') }}" style="padding: 0.5rem 0.75rem; color: #d97706; text-decoration: none; font-weight: 600; transition: color 0.3s; border: 2px solid #d97706; border-radius: 9999px; font-size: 0.75rem;">Parents</a>
                            <a href="{{ route('admin.login') }}" style="padding: 0.5rem 0.75rem; color: #8b5cf6; text-decoration: none; font-weight: 600; transition: color 0.3s; border: 2px solid #8b5cf6; border-radius: 9999px; font-size: 0.75rem;">Admin</a>
                           
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <div style="padding: 3rem 1.5rem; background: url('/image/school_background.jpg') center/cover no-repeat; background-attachment: fixed; position: relative;">
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: url('/image/school_background.jpg') center/cover no-repeat; background-attachment: fixed; filter: blur(8px); z-index: 0;"></div>
            <div style="max-width: 80rem; margin: 0 auto; position: relative; z-index: 1;">
                <div class="hero-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem; align-items: center;">
                    <!-- Left Content -->
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <h2 class="hero-title" style="font-size: 3.5rem; font-weight: 900; line-height: 1.2; margin: 0; color: white; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">
                            <span style="color: #fff;">Learning</span> is <span style="color: #fef3c7;">Fun</span> in <span style="color: rgb(168, 36, 111);">NLLC</span>!
                        </h2>
                        <p class="hero-subtitle" style="font-size: 1.25rem; color: white; line-height: 1.6; margin: 0; text-shadow: 1px 1px 3px rgba(0,0,0,0.3);">
                            An interactive e-learning platform designed specifically for kindergarten children to learn, play, and grow at their own pace.
                        </p>
                        <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                            <a href="#features" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 1rem 2rem; border: 2px solid #3b82f6; color: #3b82f6; border-radius: 9999px; text-decoration: none; font-weight: bold; font-size: 1rem; transition: all 0.3s; background: transparent; cursor: pointer;">
                                Learn More ↓
                            </a>
                        </div>
                    </div>
                    
                    <!-- Right Banner Carousel -->
                    <div style="position: relative; display: flex; align-items: center; justify-content: center; min-height: 400px; overflow: hidden;">
                        <div id="bannerCarousel" style="position: relative; width: 100%; height: 100%; min-height: 400px;">
                            <img src="/image/banner1.jpg" alt="Learning Banner 1" class="banner-slide" style="width: 100%; height: 100%; border-radius: 1.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); object-fit: cover; position: absolute; top: 0; left: 0; opacity: 1; transition: opacity 0.8s ease-in-out;">
                            <img src="/image/banner2.jpg" alt="Learning Banner 2" class="banner-slide" style="width: 100%; height: 100%; border-radius: 1.5rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); object-fit: cover; position: absolute; top: 0; left: 0; opacity: 0; transition: opacity 0.8s ease-in-out;">
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>

        <script>
            let currentBannerIndex = 0;
            const bannerSlides = document.querySelectorAll('.banner-slide');
            const totalBanners = bannerSlides.length;

            function rotateBanner() {
                bannerSlides.forEach((slide, index) => {
                    slide.style.opacity = index === currentBannerIndex ? '1' : '0';
                });
                currentBannerIndex = (currentBannerIndex + 1) % totalBanners;
            }

            // Rotate banner every 5 seconds
            setInterval(rotateBanner, 5000);
        </script>

        <!-- Features Section -->
        <section id="features" class="fade-in" style="padding: 5rem 1.5rem; background: white;">
            <div style="max-width: 80rem; margin: 0 auto;">
                    <h3 style="font-size: 2.25rem; font-weight: 900; margin: 0 0 1rem 0;">
                        Why Choose <span style="color: #3b82f6;">NLLC</span>?
                    </h3>
                    <p style="font-size: 1.25rem; color: #6b7280;">Everything your child needs to succeed in kindergarten</p>
                </div>
                
                <div class="features-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
                    <!-- Feature 1 -->
                    <div class="fade-in scale-in" style="background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%); border-radius: 1.5rem; padding: 2rem; text-align: center; transition: all 0.3s; cursor: pointer;">
                        <div style="font-size: 3.5rem; margin-bottom: 1rem;">🎮</div>
                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 0.75rem 0;">Interactive Games</h4>
                        <p style="color: #6b7280;">Engaging games and activities that make learning fun and effective for young minds.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="fade-in scale-in" style="background: linear-gradient(135deg, #f3e8ff 0%, #faf5ff 100%); border-radius: 1.5rem; padding: 2rem; text-align: center; transition: all 0.3s; cursor: pointer;">
                        <div style="font-size: 3.5rem; margin-bottom: 1rem;">👨‍👩‍👧</div>
                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 0.75rem 0;">Parent Dashboard</h4>
                        <p style="color: #6b7280;">Track progress, see achievements, and stay connected with your child's learning journey.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="fade-in scale-in" style="background: linear-gradient(135deg, #fbcfe8 0%, #fce7f3 100%); border-radius: 1.5rem; padding: 2rem; text-align: center; transition: all 0.3s; cursor: pointer;">
                        <div style="font-size: 3.5rem; margin-bottom: 1rem;">⭐</div>
                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 0.75rem 0;">Age-Appropriate</h4>
                        <p style="color: #6b7280;">Curriculum designed by educators for kindergarten learners with adjustable difficulty levels.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="fade-in scale-in" style="background: linear-gradient(135deg, #fef3c7 0%, #fef9e7 100%); border-radius: 1.5rem; padding: 2rem; text-align: center; transition: all 0.3s; cursor: pointer;">
                        <div style="font-size: 3.5rem; margin-bottom: 1rem;">🛡️</div>
                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 0.75rem 0;">Safe & Secure</h4>
                        <p style="color: #6b7280;">A distraction-free, moderated environment where kids can learn safely and confidently.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- What Kids Learn Section -->
        <section class="fade-in-up" style="padding: 5rem 1.5rem; background: linear-gradient(135deg, #eff6ff 0%, #faf5ff 100%);">
            <div style="max-width: 80rem; margin: 0 auto;">
                <h3 style="font-size: 2.25rem; font-weight: 900; text-align: center; margin-bottom: 4rem;">What Your Child Will Learn</h3>
                <div class="learning-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem;">
                    <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">📖</div>
                        <p style="font-weight: bold; color: #111827; margin: 0;">Reading</p>
                    </div>
                    <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">🔤</div>
                        <p style="font-weight: bold; color: #111827; margin: 0;">Alphabetic</p>
                    </div>
                    <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">🤝</div>
                        <p style="font-weight: bold; color: #111827; margin: 0;">Good Manner</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="scale-in" style="padding: 5rem 1.5rem; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);">
            <div style="max-width: 80rem; margin: 0 auto; text-align: center;">
                <h3 class="cta-title" style="font-size: 3rem; font-weight: 900; color: white; margin: 0 0 1.5rem 0;">
                    Start Your Child's Learning Adventure Today! 🎉
                </h3>
                <p class="cta-subtitle" style="font-size: 1.25rem; color: white; margin: 0 0 2rem 0; max-width: 42rem; margin-left: auto; margin-right: auto;">
                    Join thousands of families who are already seeing amazing results. First month is completely free!
                </p>
            </div>
        </section>

        <!-- Footer -->
        <footer style="padding: 3rem 1.5rem; background: #111827; color: white;">
            <div style="max-width: 80rem; margin: 0 auto;">
                <div style="text-align: center;">
                    <p style="margin: 0;">&copy; 2026 NLLC. All rights reserved. Making learning fun, one child at a time! 🌟</p>
                </div>
            </div>
        </footer>

        <script>
            // Intersection Observer for Scroll Animations
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all elements with animation classes
            document.querySelectorAll('.fade-in, .fade-in-up, .slide-in-left, .slide-in-right, .scale-in').forEach(el => {
                observer.observe(el);
            });

            // Apply staggered animations to feature cards
            document.querySelectorAll('.features-grid > div').forEach((el, index) => {
                el.style.transitionDelay = `${index * 0.15}s`;
            });

            // Apply staggered animations to learning items
            document.querySelectorAll('.learning-grid > div').forEach((el, index) => {
                el.style.transitionDelay = `${index * 0.15}s`;
            });
        </script>
    </body>
</html>
    </body>
</html>
