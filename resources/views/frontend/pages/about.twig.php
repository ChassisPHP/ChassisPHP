{% extends 'frontend/layout.twig.php' %}
{% block title %} ChassisPHP About {% endblock %}
{% block content %}
<div class="">
    <section>
        <div class="content-inner">
            <h1>{{ content.Title }}</h1>
            {{ content.Body }}
        </div>
    </section> 
</div>
{% endblock %}
