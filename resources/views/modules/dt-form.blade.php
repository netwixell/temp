<form class="form form--dream-team" data-aos="fade-up" data-aos-offset="200" name="registration" type="POST" action="">
  <div class="form__success"><span>Отправленно!</span></div>
  @csrf
  <p class="form__line">
    <label class="form__label">Название команды
      <input class="form__input" type="text" placeholder="Ресничкина и ко." data-invalid-msg="Введите название команды" name="name" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label">Имя контактного лица
      <input class="form__input" type="text" placeholder="Анастасия Ресничкина" data-invalid-msg="Введите имя контактного лица" name="contact_name" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label">Контактный номер
      <input class="form__input" id="tel" type="tel" placeholder="+380 (00) 000 00 00" pattern="^\+\d{3}\s\(\d{2}\)\s\d{3}\s\d{2}\s\d{2}$" data-invalid-msg="Введите телефон" name="phone" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label">Контактная е-почта
      <input class="form__input" type="email" placeholder="anastasia@mail.com" data-invalid-msg="Введите E-почту" name="email" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label">Город
      <input class="form__input" type="text" placeholder="Киев" name="city" data-invalid-msg="Введите город" pattern=".{3,}" required>
    </label>
  </p>
  <p class="form__line">
    <label class="form__label form__label--agreement">
      <input class="form__input form__input--checkbox visually-hidden" type="checkbox" name="agreement" required><span class="form__checkmark">Я ознакомлен и согласен с <a class="form__link" href="/dream-team/rules">правилами конкурса</a></span>
    </label>
  </p>
  <button class="form__button button button--unfilled-blue" type="submit"><span>Зарегестрироваться</span></button>
</form>
