{% extends 'backend/layout.twig.php' %}
{% block content %} 
<article class="container itemCenter center column">

    {% if message.content is defined %}
    <div class="item alert {{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %} 
    
    <header class="item">
        <h1>Active User Accounts</h1>
    </header>

    <a href="/backend/users/register" class="button blueBackground">Add User</a>
    <div class="item">
        <div class="Rtable Rtable--5cols center">
            {% for user in users %}
            <div class="Rtable-cell">{{ user.Id }}</div>
            <div class="Rtable-cell">{{ user.Name }}</div>
            <div class="Rtable-cell">{{ user.Email }}</div>
            <div class="Rtable-cell">{{ user.userLevel }}</div>
            <div class="Rtable-cell"><a href="/backend/users/delete/{{ user.ID }}" onclick="return confirm('Are you sure?')">DELETE</a></div>
            {% endfor %}
        </div>
    </div>

</article>
{% endblock %}
