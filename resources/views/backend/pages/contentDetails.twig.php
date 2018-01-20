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
    <div class="item">
        <div class="Rtable Rtable--5cols center">
            <div class="Rtable-cell">{{ entryDetails.Id }}</div>
            <div class="Rtable-cell">{{ entryDetails.Title }}</div>
            <div class="Rtable-cell">{{ entryDetails.Body }}</div>
            <div class="Rtable-cell">{{ entryDetails.PublicationDate|date('Y-m-d H:i:s') }}</div>
            <div class="Rtable-cell"><a href="/backend/content/delete/{{ content.ID }}" onclick="return confirm('Are you sure?')">DELETE</a></div>
        </div>
    </div>

</article>
{% endblock %}
