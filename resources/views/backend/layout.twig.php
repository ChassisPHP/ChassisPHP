<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" href="/css/main.css" />
</head>

<body>
    {% include('backend/partials/nav.twig.php') with {user:all} %}
    <main class="content center itemCenter">
        {% block content %}{% endblock %}
    </main>    
</body>
</html>
