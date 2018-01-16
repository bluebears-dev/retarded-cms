<template>
    <section>
        <div class="rcms-editor-wrapper">
            <nav class="page-toolbar">
                <div class="rcms-form-dropdown">
                    <select v-model="parent" name="parent" title="Select parent page">
                        <option v-for="page in pages" :value="page">{{page}}</option>
                    </select>
                </div>
                <input v-model="page" class="rcms-input" type="text" name="name" placeholder="Page name" required>
                <button @click="toggleVisibility" class="rcms-active-page-button">
                    <span name="published" class="fa fa-eye"></span>
                </button>
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
                page: null,
                parent: null,
                simpleMDE: null,
                published: true,
            }
        },
        computed: {
            token: function () {
                let element = document.querySelector('meta[name=csrf-token]');
                return element.content
            },
            pages: function () {
                let pages = this.$store.getters['pageManagement/pages'];

                if (pages)
                    return pages.map((element) => {
                        return element.name;
                    });
                else
                    return [];
            }
        },
        methods: {
            toggleVisibility: function () {
                this.published = !this.published;
                document.getElementsByName('published')[0].className = this.published ? 'fa fa-eye' : 'fa fa-eye-slash';
            },
            validateName(name) {
                return (name && !this.pages.includes(name) && /^[a-z0-9\-_]+$/.test(name))
            },
            savePage() {
                if (!this.parent)
                    this.parent = 'home';

                if (this.validateName(this.page)) {
                    axios({
                        method: 'post',
                        url: '/api/page',
                        data: {
                            content: this.simpleMDE.value() ? this.simpleMDE.value() : ' ',
                            name: this.page,
                            parent_page: this.parent,
                            published: this.published,
                            _token: this.token,
                        }
                    }).then(response => {
                        this.$store.commit('pageManagement/requestList');
                    }).catch(error => {
                        console.log(error)
                    })
                } else {
                    window.alert("Invalid page name")
                }
            }
        },
        mounted() {
            this.simpleMDE = new SimpleMDE({
                autoDownloadFontAwesome: false,
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
            this.$store.commit('pageManagement/requestList');
        }
    }
</script>