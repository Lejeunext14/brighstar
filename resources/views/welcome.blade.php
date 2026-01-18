<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>NLLC</title>

        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

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
            @media (max-width: 768px) { .nav-links { gap: 0.5rem; } .btn-primary, .btn-secondary { padding: 0.75rem 1rem; font-size: 0.875rem; } }
        </style>
    </head>
    <body style="background: linear-gradient(135deg, #dbeafe 0%, #f3e8ff 100%); color: #111827; margin: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;">
        <!-- Navigation Header -->
        <nav style="position: sticky; top: 0; z-index: 50; background: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            <div style="max-width: 80rem; margin: 0 auto; padding: 1rem 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <img src="/image/logo.png" alt="BrighStar Logo" style="height: 4rem; width: auto;">
                    <h1 style="font-size: 1.875rem; margin: 0; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;">NLLC</h1>
                </div>
                @if (Route::has('login'))
                    <div style="display: flex; gap: 1rem; align-items: center;">
                        @auth
                            <a href="{{ url('/dashboard') }}" style="padding: 0.5rem 1.5rem; color: #374151; text-decoration: none; font-weight: 600; transition: color 0.3s;">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" style="padding: 0.5rem 1.5rem; color: #374151; text-decoration: none; font-weight: 600; transition: color 0.3s;">Log in</a>
                            <a href="{{ route('admin.login') }}" style="padding: 0.5rem 1.5rem; color: #8b5cf6; text-decoration: none; font-weight: 600; transition: color 0.3s; border: 2px solid #8b5cf6; border-radius: 9999px;">Admin Login</a>
                           
                        @endauth
                    </div>
                @endif
            </div>
        </nav>

        <!-- Hero Section -->
        <section style="padding: 4rem 1.5rem; background: linear-gradient(135deg, #dbeafe 0%, #f3e8ff 100%);">
            <div style="max-width: 80rem; margin: 0 auto;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center;">
                    <!-- Left Content -->
                    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                        <h2 style="font-size: 3.5rem; font-weight: 900; line-height: 1.2; margin: 0;">
                            <span style="color: #3b82f6;">Learning</span> is <span style="color: #8b5cf6;">Fun</span> in <span style="color: #ec4899;">NLLC</span>!
                        </h2>
                        <p style="font-size: 1.25rem; color: #4b5563; line-height: 1.6; margin: 0;">
                            An interactive e-learning platform designed specifically for kindergarten children to learn, play, and grow at their own pace.
                        </p>
                        <div style="display: flex; flex-wrap: wrap; gap: 1rem;">
                            <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 1rem 2rem; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); color: white; border-radius: 9999px; text-decoration: none; font-weight: bold; font-size: 1.125rem; transition: all 0.3s; border: none; cursor: pointer;">
                                🚀 Get Started Free
                            </a>
                            <a href="#features" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 1rem 2rem; border: 2px solid #3b82f6; color: #3b82f6; border-radius: 9999px; text-decoration: none; font-weight: bold; font-size: 1.125rem; transition: all 0.3s; background: transparent; cursor: pointer;">
                                Learn More ↓
                            </a>
                        </div>
                        <div style="display: flex; gap: 2rem; padding-top: 1rem;">
                            <div>
                                <p style="font-size: 1.875rem; font-weight: bold; color: #3b82f6; margin: 0;">10K+</p>
                                <p style="color: #6b7280; margin: 0;">Happy Students</p>
                            </div>
                            <div>
                                <p style="font-size: 1.875rem; font-weight: bold; color: #8b5cf6; margin: 0;">500+</p>
                                <p style="color: #6b7280; margin: 0;">Activities</p>
                            </div>
                            <div>
                                <p style="font-size: 1.875rem; font-weight: bold; color: #ec4899; margin: 0;">4.9⭐</p>
                                <p style="color: #6b7280; margin: 0;">Parent Rating</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Right Illustration -->
                    <div style="position: relative;">
                        <div style="background: linear-gradient(135deg, #fef3c7 0%, #fbcfe8 50%, #bfdbfe 100%); border-radius: 1.5rem; padding: 2rem; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); text-align: center;">
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
                                <div style="font-size: 3rem;">🎨</div>
                                <div style="font-size: 3rem;">📚</div>
                                <div style="font-size: 3rem;">🎵</div>
                            </div>
                            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 1rem;">
                                <div style="font-size: 3rem;">🔢</div>
                                <div style="font-size: 3rem;">🌍</div>
                                <div style="font-size: 3rem;">🧩</div>
                            </div>
                            <p style="font-size: 0.875rem; font-weight: bold; color: #4b5563; margin-top: 1.5rem;">Learn through play!</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section id="features" style="padding: 5rem 1.5rem; background: white;">
            <div style="max-width: 80rem; margin: 0 auto;">
                <div style="text-align: center; margin-bottom: 4rem;">
                    <h3 style="font-size: 2.25rem; font-weight: 900; margin: 0 0 1rem 0;">
                        Why Choose <span style="color: #3b82f6;">NLLC</span>?
                    </h3>
                    <p style="font-size: 1.25rem; color: #6b7280;">Everything your child needs to succeed in kindergarten</p>
                </div>
                
                <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.5rem;">
                    <!-- Feature 1 -->
                    <div style="background: linear-gradient(135deg, #dbeafe 0%, #eff6ff 100%); border-radius: 1.5rem; padding: 2rem; text-align: center; transition: all 0.3s; cursor: pointer;">
                        <div style="font-size: 3.5rem; margin-bottom: 1rem;">🎮</div>
                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 0.75rem 0;">Interactive Games</h4>
                        <p style="color: #6b7280;">Engaging games and activities that make learning fun and effective for young minds.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div style="background: linear-gradient(135deg, #f3e8ff 0%, #faf5ff 100%); border-radius: 1.5rem; padding: 2rem; text-align: center; transition: all 0.3s; cursor: pointer;">
                        <div style="font-size: 3.5rem; margin-bottom: 1rem;">👨‍👩‍👧</div>
                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 0.75rem 0;">Parent Dashboard</h4>
                        <p style="color: #6b7280;">Track progress, see achievements, and stay connected with your child's learning journey.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div style="background: linear-gradient(135deg, #fbcfe8 0%, #fce7f3 100%); border-radius: 1.5rem; padding: 2rem; text-align: center; transition: all 0.3s; cursor: pointer;">
                        <div style="font-size: 3.5rem; margin-bottom: 1rem;">⭐</div>
                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 0.75rem 0;">Age-Appropriate</h4>
                        <p style="color: #6b7280;">Curriculum designed by educators for kindergarten learners with adjustable difficulty levels.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div style="background: linear-gradient(135deg, #fef3c7 0%, #fef9e7 100%); border-radius: 1.5rem; padding: 2rem; text-align: center; transition: all 0.3s; cursor: pointer;">
                        <div style="font-size: 3.5rem; margin-bottom: 1rem;">🛡️</div>
                        <h4 style="font-size: 1.25rem; font-weight: bold; color: #111827; margin: 0 0 0.75rem 0;">Safe & Secure</h4>
                        <p style="color: #6b7280;">A distraction-free, moderated environment where kids can learn safely and confidently.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- What Kids Learn Section -->
        <section style="padding: 5rem 1.5rem; background: linear-gradient(135deg, #eff6ff 0%, #faf5ff 100%);">
            <div style="max-width: 80rem; margin: 0 auto;">
                <h3 style="font-size: 2.25rem; font-weight: 900; text-align: center; margin-bottom: 4rem;">What Your Child Will Learn</h3>
                <div style="display: grid; grid-template-columns: repeat(6, 1fr); gap: 1.5rem;">
                    <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">🔢</div>
                        <p style="font-weight: bold; color: #111827; margin: 0;">Math</p>
                    </div>
                    <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">📖</div>
                        <p style="font-weight: bold; color: #111827; margin: 0;">Reading</p>
                    </div>
                    <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">🎨</div>
                        <p style="font-weight: bold; color: #111827; margin: 0;">Art</p>
                    </div>
                    <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">🎵</div>
                        <p style="font-weight: bold; color: #111827; margin: 0;">Music</p>
                    </div>
                    <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">🌍</div>
                        <p style="font-weight: bold; color: #111827; margin: 0;">Science</p>
                    </div>
                    <div style="background: white; border-radius: 1rem; padding: 1.5rem; text-align: center; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                        <div style="font-size: 3.5rem; margin-bottom: 0.75rem;">🧩</div>
                        <p style="font-weight: bold; color: #111827; margin: 0;">Logic</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section style="padding: 5rem 1.5rem; background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);">
            <div style="max-width: 80rem; margin: 0 auto; text-align: center;">
                <h3 style="font-size: 3rem; font-weight: 900; color: white; margin: 0 0 1.5rem 0;">
                    Start Your Child's Learning Adventure Today! 🎉
                </h3>
                <p style="font-size: 1.25rem; color: white; margin: 0 0 2rem 0; max-width: 42rem; margin-left: auto; margin-right: auto;">
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
    </body>
</html>
    </body>
</html>
