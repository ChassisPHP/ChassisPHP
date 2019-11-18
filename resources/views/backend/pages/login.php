{% extends 'backend/layout.twig.php' %}
{% block title %}ChassisPHP Login{% endblock %}
{% block content %}
<article class="main-content">

    {% if message.content is defined %}
    <div class="item alert alert-{{ message.type }}">
        {{ message.content }}
    </div>
    {% endif %}

    <header>
      <h1>Log In</h1>
    </header>

    <form action="/backend/login" method="post">
        <div class="form-group">
          <label>Email</label>
          <input name="email" placeholder="email" class="input-control" />
        </div>

        <div class="form-group">
          <label>Password</label>
          <input type="password" name="passwd" value="password" class="input-control" />
        </div>

        <div class="form-group">
          <label>&nbsp;</label>
          <button type="submit">Log In</button>
          <button>Cancel</button>
        </div>

        {% if message.content == 'Wrong Email or Password, please try again' %}
        <a href='/backend/forgot'>Click here to reset your password</a>
        {% endif %}
    </form>

</article>
{% endblock %}
