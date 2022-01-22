export default {
  data: () => {
    return {
      clientsTestimonialsPage: 4,
    }
  },
  methods: {
    _winClientsTestimonialsPage() {
      setInterval(() => {
        var w = window.innerWidth
        if (w < 768) {
          this.clientsTestimonialsPage = 1
        } else if (w < 960) {
          this.clientsTestimonialsPage = 2
        } else if (w < 1200) {
          this.clientsTestimonialsPage = 3
        } else {
          this.clientsTestimonialsPage = 4
        }
      }, 100)
    },
    _isScreen767() {
      return this.clientsTestimonialsPage == 1
    },
    getImgUrl(url) {
      if (url) {
        return url
      }
      
      return 'https://placehold.jp/100x100.png'
    },
  },
  css: {
    menuOpen: 'is-open',
  },
}