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
    
    <a href="/backend/content" class="button blueBackground">All Content</a>
    <div class="col60">
        <div class="item itemCenter">
            <h1 class="">{{ entryDetails.Title }}</h1>
            <p>{{ entryDetails.Body }}</p>
            <div class="Rtable-cell">{{ entryDetails.PublicationDate|date('Y-m-d H:i:s') }}</div>
            <button class="button redBackground"><a href="/backend/content/delete/{{ content.ID }}" onclick="return confirm('Are you sure?')">DELETE</a></button>
            </div>
        </div>
    </div>
</article>
{% endblock %}
