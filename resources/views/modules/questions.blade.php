<section class="questions">
  <div class="questions__container container">
    <div class="questions__title-wrapper">
      <h3 class="questions__title">Остались вопросы?</h3>
      <p class="questions__description">Позвоните или напишите нам</p>
    </div>
    <ul class="questions__contacts">
      <li class="questions__contact-wrapper"><a class="questions__contact" href="tel:+380665583107">+38 066 558 31 07</a></li>
      <li class="questions__contact-wrapper"><a class="questions__contact" href="tel:+380983187115">+38 098 318 71 15</a></li>
      <li class="questions__contact-wrapper"><a class="questions__contact" href="mailto:inbox@molfarforum.com?subject=Molfar 2019">inbox@molfarforum.com</a></li>
    </ul>
    <div class="questions__socials"><b class="questions__socials-title">Хотите быть в курсе новостей?</b>
      <p class="questions__socials-description">Подписывайтесь на нас в <a class="questions__socials-link" href="https://www.facebook.com/molfarforum" target="_blank", rel="noopener">facebook</a> и <a class="questions__socials-link" href="https://www.instagram.com/molfarforum/" target="_blank", rel="noopener">instagram</a></p>
    </div>

    <form class="form form--molfar" name="callback" method="POST" action="/callback" data-aos="fade-up" data-aos-offset="200">
      <div class="form__success"><span>Отправленно!</span></div>
      @csrf
      <p class="form__line">
        <label class="form__label">Имя
          <input class="form__input" type="text" data-invalid-msg="Введите имя" name="name" placeholder="Анастасия Ресничкина" required>
        </label>
      </p>
      <p class="form__line">
        <label class="form__label">Телефон
          <input class="form__input" type="tel" id="tel" data-invalid-msg="Введите телефон" name="phone" pattern="^\+\d{3}\s\(\d{2}\)\s\d{3}\s\d{2}\s\d{2}$" placeholder="+380 (00) 000 00 00" required>
        </label>
      </p>
      <p class="form__line">
        <label class="form__label">Е-почта
          <input class="form__input" type="email" name="email" data-invalid-msg="Введите E-почту" placeholder="anastasia@mail.com" required>
        </label>
      </p>
        <p class="form__line">
          <label class="form__label">Ваш вопрос
            <textarea class="form__textarea" id="textarea" name="question" rows="5" maxlength="65535" placeholder="Я могу купить билеты всему салону?"></textarea>
          </label>
        </p>
      <button class="form__button button button--unfilled" type="submit"><span>Отправить</span></button>
    </form>

  </div>
</section>
