<section class="questions">
  <div class="questions__container container">
    <div class="questions__title-wrapper">
      <h3 class="questions__title">@lang('questions.title')</h3>
      <p class="questions__description">@lang('questions.description')</p>
    </div>
    <ul class="questions__contacts">
      <li class="questions__contact-wrapper"><a class="questions__contact" href="tel:+380665583107">+38 066 558 31 07</a></li>
      <li class="questions__contact-wrapper"><a class="questions__contact" href="tel:+380983187115">+38 098 318 71 15</a></li>
      <li class="questions__contact-wrapper"><a class="questions__contact" href="mailto:inbox@molfarforum.com">inbox@molfarforum.com</a></li>
    </ul>
    <div class="questions__socials"><b class="questions__socials-title">@lang('questions.socials-title')</b>
      <p class="questions__socials-description">
        {!!__('questions.socials-description', [
            'facebook'=>'<a class="questions__socials-link" href="https://www.facebook.com/molfarforum" target="_blank" rel="noopener">facebook</a>',
            'instagram'=>'<a class="questions__socials-link" href="https://www.instagram.com/molfarforum/" target="_blank" rel="noopener">instagram</a>'
        ])!!}
        </p>
    </div>

    <form class="form form--molfar" name="callback" method="POST" action="/callback" data-aos="fade-up" data-aos-offset="200">
      <div class="form__success"><span>@lang('questions.form_success')</span></div>
      @csrf
      <p class="form__line">
        <label class="form__label">@lang('questions.label_name')
          <input class="form__input" type="text" data-invalid-msg="@lang('questions.error_name')" name="name" placeholder="@lang('questions.placeholder_name')" required>
        </label>
      </p>
      <p class="form__line">
        <label class="form__label">@lang('questions.label_phone')
          <input class="form__input" type="tel" id="tel" data-invalid-msg="@lang('questions.error_phone')" name="phone" pattern="^\+\d{3}\s\(\d{2}\)\s\d{3}\s\d{2}\s\d{2}$" placeholder="@lang('questions.placeholder_phone')" required>
        </label>
      </p>
      <p class="form__line">
        <label class="form__label">@lang('questions.label_email')
          <input class="form__input" type="email" name="email" data-invalid-msg="@lang('questions.error_email')" placeholder="@lang('questions.placeholder_email')" required>
        </label>
      </p>
        <p class="form__line">
          <label class="form__label">@lang('questions.label_question')
            <textarea class="form__textarea" id="textarea" name="question" rows="5" maxlength="65535" placeholder="@lang('questions.placeholder_question')"></textarea>
          </label>
        </p>
      <button class="form__button button button--unfilled" type="submit"><span>@lang('questions.submit')</span></button>
    </form>

  </div>
</section>
