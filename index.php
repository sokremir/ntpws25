<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Random Page</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
        header, footer { background-color: #f8f8f8; padding: 20px; text-align: center; }
        main { padding: 20px; }
    </style>
</head>
<body>

<?php
// Random headers
$headers = [
    "Welcome to Our Awesome Website!",
    "Explore the World of Coding",
    "Your Gateway to Learning",
    "Innovate and Create",
    "Discover Endless Possibilities"
];

// Random body content
$bodies = [
    "This is a platform where you can learn new skills, explore different technologies, and become a better developer. Join us in our journey of learning and growth.",
    "We provide tutorials, resources, and tools to help you master web development, data science, and much more. Stay curious and keep coding!",
    "Whether you're a beginner or an expert, there's always something new to discover. Start your adventure in coding today with our resources.",
    "Our community is filled with creators, learners, and innovators. Share your knowledge, collaborate with others, and expand your skillset.",
    "Embrace the future with technology. We provide the tools and knowledge to help you thrive in the ever-changing tech landscape."
];

// Random footers
$footers = [
    "© 2024 All Rights Reserved | Powered by Creativity",
    "Stay Connected: Follow us on social media for updates.",
    "© 2024 WebDev Co. | Designed with Passion",
    "Keep Learning. Keep Growing. Keep Innovating.",
    "Contact us: info@example.com | © 2024"
];

// Pick random header, body, and footer
$randomHeader = $headers[array_rand($headers)];
$randomBody = $bodies[array_rand($bodies)];
$randomFooter = $footers[array_rand($footers)];
?>

<!-- Header -->
<header>
    <h1><?php echo $randomHeader; ?></h1>
</header>

<!-- Main Content -->
<main>
    <p><?php echo $randomBody; ?></p>
</main>

<!-- Footer -->
<footer>
    <p><?php echo $randomFooter; ?></p>
</footer>

</body>
</html>
