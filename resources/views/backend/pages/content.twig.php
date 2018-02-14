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
    <div class="item Rtable col90">
        <div class="cell col10">Position</div>
        <div class="cell col20">Title</div>
        <div class="cell col20">Body</div>
        <div class="cell col10">Author</div>
        <div class="cell col10">Updated By</div>
        <div class="cell col10">Pub Date</div>
        <div class="cell col10">Last Updated</div>
        <div class="cell col5"></div>
        <div class="cell col5"></div>
        
        {% for content in contents %}
        <div class="cell col10">{{ content.Position }}</div>
        <div class="cell col20">{{ content.Title }}</div>
        <div class="cell col20">{{ content.Body|length > 50 ? content.Body|slice(0,50) ~ ' ....' : content.Body }}</div>
        <div class="cell col10">{{ content.Author.Name }}</div>
        <div class="cell col10">{{ content.UpdatedBy.Name }}</div>
        <div class="cell col10">{{ content.PublicationDate|date('Y-m-d') }}</div>
        <div class="cell col10">{{ content.Updated|date('Y-m-d') }}</div>
        <div class="cell col5"><a href="/backend/content/{{ content.ID }}">Details</a></div>
        <div class="cell col5"><a href="/backend/content/delete/{{ content.ID }}" onclick="return confirm('Are you sure?')">Delete</a></div>
        {% endfor %}
    </div>

</article>
{% endblock %}
