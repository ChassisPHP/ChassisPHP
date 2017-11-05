{% extends 'backend/layout.twig.php' %}
{% block content %} 
<?php print_r($users); ?>
<article class="container itemCenter column">

    <header class="item">
        <h1>Active User Accounts</h1>
    </header>
  
    <div class="item">
        <ul>
        {% for user in users %}
            <li>{{ user.Id }} {{ user.UserName }} {{ user.Email }} {{ user.userLevel }}</li>
        {% endfor %}
        </ul>
    </div>

</article>
{% endblock %}
