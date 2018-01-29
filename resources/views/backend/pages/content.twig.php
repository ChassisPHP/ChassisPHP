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
    
    <a href="/backend/content/create" class="button blueBackground">Add Content</a>
    <div class="item">
        <div class="Rtable Rtable--7cols center">
            {% for content in contents %}
            <div class="Rtable-cell">{{ content.Position }}</div>
            <div class="Rtable-cell">{{ content.Title }}</div>
            <div class="Rtable-cell">{{ content.Body }}</div>
            <div class="Rtable-cell">{{ content.Author }}</div>
            <div class="Rtable-cell">{{ content.PublicationDate|date('Y-m-d H:i:s') }}</div>
            <div class="Rtable-cell"><a href="/backend/content/{{ content.ID }}">View Details</a></div>
            <div class="Rtable-cell"><a href="/backend/content/delete/{{ content.ID }}" onclick="return confirm('Are you sure?')">DELETE</a></div>
            {% endfor %}
        </div>
    </div>

</article>
{% endblock %}
