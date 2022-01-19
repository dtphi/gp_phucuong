<template>
  <div class="mt-4">
    <h4 class="tit-common clr-orange">Hạnh các thánh</h4>
    <div
      id="Hanhcacthanh-PlaylistYoutube"
      class="embed-responsive embed-responsive-4by3"
    >
      <iframe
        allowfullscreen=""
        class="embed-responsive-item"
        frameborder="0"
        height="360"
        src="https://www.youtube-nocookie.com/embed/videoseries?list=PL-uyh2tqni7nLxdHqWjTbLyIoJEriY7lM"
        width="640"
      ></iframe>
    </div>
    <module-tag-right></module-tag-right>
  </div>
</template>

<script>
import ModuleTagRight from '../tags/right'

export default {
  name: 'ModuleHanhCacThanh',
  components: { ModuleTagRight, },
  data() {
    return {}
  },
}
</script>
