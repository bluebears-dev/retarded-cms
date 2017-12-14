<template>
    <section>
        <div class="rcms-editor-wrapper">
            <nav class="page-toolbar">
                <div class="rcms-form-dropdown">
                    <select v-model="pages" name="parent_page" title="Select parent page" required>
                        <option v-for="page in pages" :value="page.name">{{page.name}}</option>
                    </select>
                </div>
                <input class="rcms-input" type="text" name="page_name" placeholder="Page name" required>

            </nav>
            <textarea id="rcms-editor"></textarea>
        </div>
    </section>
</template>

<script>
    import SimpleMDE from 'simplemde'
    import hljs from 'highlight.js/styles/github.css'

    export default {
        data() {
            return {
                simpleMDE: null,
                saved: false,
                pages: {}
            }
        },
        computed: {
            token: function () {
                let element = document.querySelector("meta[name=csrf-token]");
                return element.content
            }
        },
        methods: {
          savePage() {
              this.simpleMDE.clearAutosavedValue();
              axios({
                  method: 'post',
                  url: '/api/page/add',
                  data: {
                      content: this.simpleMDE.value(),
                      name: 'page',
                      parent_page: '/',
                      active: true,
                      _token: this.token,
                  }
              }).then(response => {
                  console.log(response.data);
                  this.saved = true;
                  this.simpleMDE.clearAutosavedValue();
              }).catch(error => {
                console.log(error)
              })
          }
        },
        mounted() {
            this.simpleMDE = new SimpleMDE({
                autoDownloadFontAwesome: false,
                autosave: {
                    enabled: true,
                    uniqueId: "rcms-editor" + this.$store.getters['userManagement/username']
                },
                element: document.getElementById("rcms-editor"),
                renderingConfig: {
                    codeSyntaxHighlighting: true
                },
                shortcuts: {
                    togglePreview: 'Alt-P'
                },
                toolbar: [
                    'preview', '|',
                    'bold', 'italic', 'strikethrough', 'code', 'quote', '|',
                    'heading-bigger', 'heading-smaller', 'unordered-list', 'ordered-list', 'table', '|',
                    'link', 'image', 'horizontal-rule', '|',
                    'guide', '|',
                    {
                        name: 'save',
                        action: this.savePage,
                        className: "fa fa-floppy-o",
                        title: "Save page",
                    },
                ],
                forceSync: true,
                toolbarTips: true,
            });

            let pageData = this.$store.getters['main/pageData'];
            if (pageData && !pageData.content)
                this.simpleMDE.value(pageData.content);
            this.saved = false;

            let toolbar = $('.editor-toolbar');
            toolbar.append('<i class="separator"></i>');
            toolbar.append('<i class="separator"></i>');
        },
        beforeDestroy() {
            if (!this.saved)
                this.$store.commit('main/savePageData', { content: this.simpleMDE.value()})
        }
    }
</script>