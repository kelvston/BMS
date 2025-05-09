<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Business Management System</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Add to your existing styles */
        .glass-card {
            background: rgba(40, 97, 182, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border-radius: 1rem;
            transition: all 0.3s ease;
            transform-style: preserve-3d;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            border-left: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card:hover {
            transform: translateY(-5px) rotateX(5deg) rotateY(5deg);
            box-shadow: 0 15px 35px rgba(0, 255, 255, 0.2);
        }

        .glass-btn {
            background: rgba(6, 182, 212, 0.1);
            border: 1px solid rgba(6, 182, 212, 0.3);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .glass-btn:hover {
            border-color: rgba(6, 182, 212, 0.6);
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.3);
        }

        :root {
            --primary: #06b6d4;
            --primary-light: #0ea5e9;
            --dark: #0f172a;
            --darker: #020617;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--darker), var(--dark));
            background-size: 400% 400%;
            animation: gradientFlow 12s ease infinite;
            color: white;
            min-height: 100vh;
            overflow-x: hidden;
            perspective: 1000px;
        }

        @keyframes gradientFlow {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        /* Particle.js container */
        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
            top: 0;
            left: 0;
        }

        /* Glass effect - enhanced from welcome page */
        .glass {
            background: rgba(40, 97, 182, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(20px) saturate(180%);
            border-radius: 1.5rem;
            box-shadow: 0 15px 35px rgba(0, 255, 255, 0.15),
                inset 0 0 10px rgba(255, 255, 255, 0.05);
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.5s ease;
        }

        .glass::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(ellipse at top left,
                    rgba(255, 255, 255, 0.09),
                    transparent);
            border-radius: inherit;
            z-index: -1;
            opacity: 0.8;
            pointer-events: none;
        }

        /* Floating cubes decoration */
        .cube {
            position: fixed;
            width: 20px;
            height: 20px;
            background: rgba(6, 182, 212, 0.3);
            border: 1px solid rgba(6, 182, 212, 0.5);
            transform-style: preserve-3d;
            animation: floatCube 15s infinite linear;
            z-index: -1;
        }

        @keyframes floatCube {
            0% {
                transform: rotate(0deg) translateX(0) translateY(0) translateZ(0);
                opacity: 0;
            }

            50% {
                opacity: 0.8;
            }

            100% {
                transform: rotate(360deg) translateX(100px) translateY(100px) translateZ(100px);
                opacity: 0;
            }
        }

        /* Logo styles */
        .logo-main {
            font-size: 3.5rem;
            font-weight: 900;
            color: var(--primary);
            text-shadow: 0 0 15px rgba(6, 182, 212, 0.7);
            letter-spacing: -1px;
            margin-bottom: 0.5rem;
            display: inline-block;
            animation: textGlow 3s ease-in-out infinite alternate;
        }

        @keyframes textGlow {
            from {
                text-shadow: 0 0 10px rgba(6, 182, 212, 0.7);
            }

            to {
                text-shadow: 0 0 20px rgba(6, 182, 212, 0.9),
                    0 0 30px rgba(6, 182, 212, 0.5);
            }
        }

        /* Spinner overlay */
        .spinner-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(15, 23, 42, 0.8);
            z-index: 9999;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .spinner {
            width: 64px;
            height: 64px;
            border: 8px solid rgba(255, 255, 255, 0.15);
            border-top: 8px solid var(--primary);
            border-radius: 50%;
            animation: spin 1s linear infinite, pulse 2s ease-in-out infinite;
            box-shadow: 0 0 0 0 rgba(6, 182, 212, 0.5);
            transform-style: preserve-3d;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg) rotateX(20deg);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(6, 182, 212, 0.5);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(6, 182, 212, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(6, 182, 212, 0);
            }
        }

        /* Button styles */
        .glow-btn {
            padding: 0.75rem 2rem;
            font-weight: 600;
            background-color: var(--primary);
            color: var(--dark);
            border-radius: 0.75rem;
            box-shadow: 0 0 20px var(--primary);
            transition: all 0.3s ease;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transform: translateZ(20px);
            border: none;
            cursor: pointer;
        }

        .glow-btn::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to bottom right,
                    rgba(255, 255, 255, 0.3) 0%,
                    rgba(255, 255, 255, 0) 60%);
            transform: rotate(30deg);
            transition: all 0.3s ease;
        }

        .glow-btn:hover {
            background-color: var(--primary-light);
            color: white;
            box-shadow: 0 0 30px var(--primary-light),
                0 0 50px var(--primary-light) inset;
            transform: translateZ(30px) scale(1.05);
        }

        .glow-btn:hover::before {
            left: 100%;
        }

        /* Main content container */
        .main-content {
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 120px);
            /* Adjust based on your header/footer height */
        }
    </style>
</head>

<body>
    <!-- Particle.js background -->
    <div id="particles-js"></div>

    <!-- Floating cubes decoration -->
    <div class="cube" style="top: 20%; left: 10%; animation-delay: 0s;"></div>
    <div class="cube" style="top: 70%; left: 80%; animation-delay: 2s;"></div>
    <div class="cube" style="top: 30%; left: 60%; animation-delay: 4s;"></div>
    <div class="cube" style="top: 80%; left: 30%; animation-delay: 6s;"></div>

    <!-- Spinner overlay -->
    <div class="spinner-overlay" id="spinnerOverlay">
        <div class="spinner"></div>
    </div>

    <div class="min-h-screen">
        @include('partials.navigation')

        <main class="main-content container mx-auto py-6 px-4">
            @yield('content')
        </main>
    </div>

    @include('partials.footer')

    <!-- Particle.js library -->
    <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
    <script>
        // Initialize particles.js
        document.addEventListener('DOMContentLoaded', function () {
            particlesJS('particles-js', {
                "particles": {
                    "number": {
                        "value": 80,
                        "density": {
                            "enable": true,
                            "value_area": 800
                        }
                    },
                    "color": {
                        "value": "#06b6d4"
                    },
                    "shape": {
                        "type": "circle",
                        "stroke": {
                            "width": 0,
                            "color": "#000000"
                        },
                        "polygon": {
                            "nb_sides": 5
                        }
                    },
                    "opacity": {
                        "value": 0.5,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 1,
                            "opacity_min": 0.1,
                            "sync": false
                        }
                    },
                    "size": {
                        "value": 3,
                        "random": true,
                        "anim": {
                            "enable": true,
                            "speed": 2,
                            "size_min": 0.1,
                            "sync": false
                        }
                    },
                    "line_linked": {
                        "enable": true,
                        "distance": 150,
                        "color": "#06b6d4",
                        "opacity": 0.2,
                        "width": 1
                    },
                    "move": {
                        "enable": true,
                        "speed": 1,
                        "direction": "none",
                        "random": true,
                        "straight": false,
                        "out_mode": "out",
                        "bounce": false,
                        "attract": {
                            "enable": true,
                            "rotateX": 600,
                            "rotateY": 1200
                        }
                    }
                },
                "interactivity": {
                    "detect_on": "canvas",
                    "events": {
                        "onhover": {
                            "enable": true,
                            "mode": "grab"
                        },
                        "onclick": {
                            "enable": true,
                            "mode": "push"
                        },
                        "resize": true
                    },
                    "modes": {
                        "grab": {
                            "distance": 140,
                            "line_linked": {
                                "opacity": 0.5
                            }
                        },
                        "push": {
                            "particles_nb": 4
                        }
                    }
                },
                "retina_detect": true
            });

            // 3D tilt effect for glass elements
            const glassElements = document.querySelectorAll('.glass');
            document.addEventListener('mousemove', (e) => {
                const xAxis = (window.innerWidth / 2 - e.pageX) / 25;
                const yAxis = (window.innerHeight / 2 - e.pageY) / 25;

                glassElements.forEach(glass => {
                    glass.style.transform = `rotateY(${xAxis}deg) rotateX(${yAxis}deg)`;
                });
            });

            // Reset position when mouse leaves
            document.addEventListener('mouseleave', () => {
                glassElements.forEach(glass => {
                    glass.style.transform = 'rotateY(0deg) rotateX(0deg)';
                });
            });
        });

        // Global spinner function
        function showSpinner(event) {
            if (event) event.preventDefault();
            const overlay = document.getElementById('spinnerOverlay');
            overlay.style.display = 'flex';

            if (event) {
                const link = event.target.getAttribute('href');
                setTimeout(() => {
                    window.location.href = link;
                }, 500);
            }
        }

        // Add spinner to all internal links
        document.querySelectorAll('a').forEach(link => {
            if (link.href && !link.href.startsWith('http') && !link.href.startsWith('mailto') && !link.href.startsWith('tel')) {
                link.addEventListener('click', showSpinner);
            }
        });
    </script>
</body>

</html>