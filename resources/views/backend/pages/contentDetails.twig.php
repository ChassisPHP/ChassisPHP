{% extends 'backend/layout.twig.php' %}
{% block content %} 
<article class="container itemCenter center column">

    {% if message.content is defined %}
    <div class="item alert {{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %} 
    
    <header class="item">
        <h1>Content</h1>
    </header>
    
    <a href="/backend/content" class="button button-medium blueBackground">All Content</a>
    <div class="col60">
        <div class="item itemCenter">
            <h1 class="">{{ content.Title }}</h1>
            <p>{{ content.Body }}</p>
            <div class="Rtable-cell">{{ content.PublicationDate|date('Y-m-d H:i:s') }}</div>
            <a href="/backend/content/update/{{ content.ID }}" class="button button-medium blueBackground">Edit</a>
            <a href="/backend/content/delete/{{ content.ID }}" class="button button-medium redBackground" onclick="return confirm('Are you sure?')">DELETE</a>
            </div>
        </div>
    </div>
</article>
{% endblock %}
