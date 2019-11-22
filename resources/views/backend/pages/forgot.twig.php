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
      <h1>Reset Password</h1>
    </header>


    <form action="/backend/forgot" method="post">
        <div class="form-group">
          <label>Email</label>
          <input name="email" placeholder="email" class="input-control"{% if formVars.email is defined %} value="{{ formVars.email }}"{% endif %} />
        </div>

        <div class="form-group">
          <label>&nbsp;</label>
          <button type="submit">Continue</button>
          <a href="/backend/login" class="button button-medium redBackground">Cancel</a>
        </div>

        {% if message.content == 'Could not reset your password, please contact support' %}
        <a href='mailto:{{ supportAddress }}'>Contact Support</a>
        {% endif %}
    </form>

</article>
{% endblock %}
