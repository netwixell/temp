<form class="form form--dream-team" data-aos="fade-up" data-aos-offset="200" name="registration" type="POST" action="">
  <div class="form__success"><span>@lang('dream-team-page.form__success')</span></div>
  @csrf
  <p class="form__line">
    <label class="form__label">@lang('dream-team-page.form__name')
      <input class="form__input" type="text" placeholder="@lang('dream-team-page.form__name--placeholder')" data-invalid-msg="@lang('dream-team-page.form__name--error')" name="name" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label">@lang('dream-team-page.form__contact_name')
      <input class="form__input" type="text" placeholder="@lang('dream-team-page.form__contact_name--placeholder')" data-invalid-msg="@lang('dream-team-page.form__contact_name--error')" name="contact_name" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label">@lang('dream-team-page.form__phone')
      <input class="form__input" id="tel" type="tel" placeholder="+380 (00) 000 00 00" pattern="^\+\d{3}\s\(\d{2}\)\s\d{3}\s\d{2}\s\d{2}$" data-invalid-msg="@lang('dream-team-page.form__phone--error')" name="phone" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label">@lang('dream-team-page.form__email')
      <input class="form__input" type="email" placeholder="@lang('dream-team-page.form__email--placeholder')" data-invalid-msg="@lang('dream-team-page.form__email--error')" name="email" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label">@lang('dream-team-page.form__city')
      <input class="form__input" type="text" placeholder="@lang('dream-team-page.form__city--placeholder')" name="city" data-invalid-msg="@lang('dream-team-page.form__city--error')" pattern=".{3,}" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label form__label--agreement">
      <input class="form__input form__input--checkbox visually-hidden" type="checkbox" name="agreement" required><span class="form__checkmark">@lang('dream-team-page.form__agreement--1')<a class="form__link" href="/dream-team/rules">@lang('dream-team-page.form__agreement--2')</a></span>
    </label>
  </p>
  <button class="form__button button button--unfilled-blue" type="submit"><span>@lang('dream-team-page.form__button')</span></button>
</form>
