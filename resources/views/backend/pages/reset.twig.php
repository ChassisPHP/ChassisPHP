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


    <form action="/backend/reset/{{ hash }}" method="post">
        <div class="form-group">
          <label>Password</label>
          <input name="passwd" type="password" class="input-control" />
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input name="confirmPasswd" type="password" class="input-control" />
        </div>

        <div class="form-group">
          <label>&nbsp;</label>
          <button type="submit">Reset</button>
          <button>Cancel</button>
        </div>
    </form>

</article>
{% endblock %}
