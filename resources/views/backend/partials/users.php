{% extends 'backend/layout.html.twig' %}
{% block content %} 
<?php print_r($users); ?>
<article class="main-content">

    <header>
        <h1>Active User Accounts</h1>
    </header>
  
    <div>
        <ul>
        {% for user in users %}
            <li>{{ user.Id }} {{ user.UserName }} {{ user.Email }} {{ user.userLevel }}</li>
        {% endfor %}
        </ul>
    </div>

</article>
{% endblock %}
