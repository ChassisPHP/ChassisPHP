<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>HTML 5 complete</title>
    <link rel="stylesheet" href="/css/main.css" />
</head>

<body>
    {{ include('backend/partials/nav.twig.php') }}
    <main class="content center itemCenter">
        {% block content %}{% endblock %}
    </main>    
</body>
</html>
