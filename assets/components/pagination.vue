<template>
  <nav aria-label="...">
    <ul class="pagination">
      <li class="page-item" :class="hasPrevious ? '' : 'disabled'">
        <a class="page-link" @click.prevent="pager(-1)">Anterior</a>
      </li>
      <li
        v-for="(page, key) in pages"
        :key="key"
        class="page-item"
        :class="enableActive === key ? 'active' : ''"
        aria-current="page"
      >
        <a class="page-link" @click.prevent="pager(page)">{{ page }}</a>
      </li>
      <li class="page-item" :class="hasNext ? '' : 'disabled'">
        <a class="page-link" @click.prevent="pager(0)">Siguiente</a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  name: "Pagination",
  props: {
    currentPage: {
      type: Number,
      default: 1,
    },
    hasNext: {
      type: Boolean,
      required: true,
    },
    hasPrevious: {
      type: Boolean,
      required: true,
    },
    maxPages: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      pages: [],
    };
  },
  created() {
    this.getPages;
  },
  computed: {
    enableActive() {
      return this.currentPage - 1;
    },
  },
  methods: {
    pager(page) {
      return this.$emit("pager", page);
    },
  },
  watch: {
    maxPages() {
      console.log("pages");
      for (let i = 0; i < this.maxPages; i++) {
        let b = i + 1;
        this.pages.push(b);
      }
    },
  },
};
</script>
