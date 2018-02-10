{% extends 'frontend/layout.twig.php' %}
{% block title %} ChassisPHP About {% endblock %}
{% block content %}
<h1>{{ content.Title }}</h1>
<div class="">
    {{ content.Body }} 
</div>
{% endblock %}
