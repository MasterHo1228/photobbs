<footer class="footer">
  <div class="container">
    <p class="float-left">
      <a href="https://space.bilibili.com/3051298" target="_blank">艺术源于生活</a>
    </p>

    @if (getenv('CN_SITE_RECORD'))
    <p class="float-left site-record">
      <a href="http://beian.miit.gov.cn/" target="_blank">{{ getenv('CN_SITE_RECORD') }}</a>
    </p>
    @endif

    <p class="float-right"><a href="mailto:{{ setting('contact_email') }}">联系我们</a></p>
  </div>
</footer>
