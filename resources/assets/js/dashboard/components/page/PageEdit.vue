<template>
    <section>
        <div class="rcms-editor-wrapper">
            <nav class="page-toolbar">
                <div class="rcms-form-dropdown">
                    <select v-model="parent" name="parent" title="Select parent page" required>
                        <option v-for="current_page in pages" v-if="current_page !== page" :value="current_page">{{current_page}}</option>
                    </select>
                </div>
                <input v-model="name" class="rcms-input" type="text" name="name" placeholder="Page name" required>
                <button v-on:click="toggleVisibility()" class="rcms-active-page-button">
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
        props: ['page'],
        data() {
            return {
                name: this.page,
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

                let func = (name) => {
                    return (element) =>    {
                        if (element.name !== name)
                            return element.name;
                        return null
                    }
                };

                if (pages)
                    return pages.map(func(this.page)).filter(n => n);
                else
                    return []
            }
        },
        methods: {
            toggleVisibility() {
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
                        method: 'put',
                        url: '/api/page/' + this.page,
                        data: {
                            content: this.simpleMDE.value() ? this.simpleMDE.value() : ' ',
                            name: this.name,
                            parent_page: this.parent,
                            published: this.published,
                            _token: this.token,
                        }
                    }).then(response => {
                        this.$store.commit('pageManagement/requestList');
                        this.page = this.name;
                    }).catch(error => {
                        console.log(error)
                    })
                } else {
                    window.alert("Invalid page name")
                }
            },
            getPage() {
                axios({
                    method: 'get',
                    url: '/api/page/' + this.page
                }).then(response => {
                    let page = response.data.page;
                    if (page) {
                        this.simpleMDE.value(page.content);
                        this.name = page.name;
                        this.published = page.published;
                        if (this.validateName(page.parent_page))
                            this.parent = page.parent_page
                    }
                }).catch(error => {
                    console.log(error)
                })
            }
        },
        mounted() {
            this.simpleMDE = new SimpleMDE({
                autoDownloadFontAwesome: false,
                autosave: false,
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
            this.getPage();
        }
    }
</script>