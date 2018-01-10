<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>{% block title %}{% endblock %}</title>
    <link rel="stylesheet" href="/css/main.css" />
</head>
<body>
    {% include('frontend/partials/nav.twig.php') %}
    {% block content %}{% endblock %}    
</body>
</html>
