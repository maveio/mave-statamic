<template>
    <div>
        <div v-if="value" class="mave-relative">
            <mave-player :embed="value"
                class="mave-w-full mave-aspect-video mave-rounded-md mave-overflow-hidden" :theme="theme" :style="{ 'background-image': 'url(//space-' + value.substr(0, 5) + '.video-dns.com/' + value.substr(5, 14) + '/poster.jpg', 'background-size': 'cover' }"></mave-player>
            <div
                class="mave-absolute mave-top-0 mave-left-0 mave-rounded-md mave-w-full mave-aspect-video mave-ring-1 mave-ring-inset mave-ring-black mave-ring-opacity-10 mave-pointer-events-none">
            </div>
            <div class="mave-absolute mave-right-4 mave-top-4 mave-bg-white mave-p-0.5 mave-rounded-md">
                <dropdown-list placement="bottom-center">
                    <dropdown-item text="Change" @click="openSearchModal" />
                    <dropdown-item text="Remove" @click="update(null)" />
                </dropdown-list>
            </div>
        </div>

        <button v-else class="btn" @click="openSearchModal">Browse videos</button>

        <stack v-if="searchModalIsOpen" @closed="searchModalIsOpen = false">
            <div slot-scope="{ close }" class="mave-flex mave-flex-col mave-h-full mave-bg-white">

                <header
                    class="bg-white pl-6 pr-3 py-2 mb-4 border-b shadow-md text-lg font-medium flex items-center justify-between">
                    Select a video
                    <button type="button" class="btn-close" @click="searchModalIsOpen = false">×</button>
                </header>

                <div class="mave-px-6 mave-py-3 mave-flex-1 mave-flex mave-flex-col mave-overflow-hidden">
                    <mave-list class="mave-grid mave-w-full mave-grid-cols-5 mave-gap-3" v-bind:token="token">
                        <div name="mave-list-root" class="relative mave-aspect-video mave-relative mave-rounded-lg mave-border mave-border-stone-100">
                            <div class="mave-w-full mave-h-full mave-flex mave-items-center mave-justify-center mave-text-3xl mave-font-bold mave-text-stone-400 mave-cursor-pointer" slot="root-link">
                                <div class="mave-mb-4">...</div>
                            </div>
                        </div>
                        <div name="mave-list-folder" class="relative mave-aspect-video mave-relative mave-rounded-lg mave-bg-stone-100">
                            <div class="mave-w-full mave-h-full mave-cursor-pointer" slot="folder-link">
                                <div class="mave-absolute mave--top-1 mave-w-8 mave-h-4 mave-bg-stone-100 mave-rounded-lg"></div>
                                <div slot="folder-title"
                                    class="mave-w-32 mave-absolute mave-text-xs mave-left-2 mave-text-stone-400 mave-font-medium mave-top-1.5 mave-p-1 mave-truncate mave-h-6">
                                </div>
                                <div slot="folder-count"
                                    class="mave-absolute mave-text-xs mave-right-2 mave-text-stone-400 mave-bottom-1.5 mave-p-1 mave-truncate mave-h-6">
                                </div>
                            </div>
                        </div>
                        <div name="mave-list-item"
                            class="mave-aspect-video mave-relative mave-rounded-lg mave-bg-stone-100 mave-cursor-pointer mave-overflow-hidden"
                            onclick="document.dispatchEvent(new CustomEvent('mave:select', {detail: this}))">
                            <div slot="item-title"
                                class="mave-w-32 mave-absolute mave-text-xs mave-right-1.5 mave-text-white mave-bottom-1.5 mave-rounded-lg mave-bg-black mave-bg-opacity-60 mave-px-1.5 mave-py-1 mave-truncate mave-h-6">
                            </div>
                            <div class="mave-w-full mave-h-full mave-absolute mave-ring-1 mave-ring-inset mave-ring-black mave-ring-opacity-5 mave-rounded-lg"></div>
                            <mave-img class="block"></mave-img>
                        </div>
                    </mave-list>

                </div>

            </div>
        </stack>

    </div>
</template>

<script>
import "https://cdn.video-dns.com/npm/@maveio/components/+esm";

export default {

    mounted() {
        document.addEventListener('mave:select', (e) => {
            if (this.searchModalIsOpen) {
                const img = e.detail.querySelector('mave-img')
                this.update(img.getAttribute('embed'))
                this.searchModalIsOpen = false
            }
        })
    },

    mixins: [Fieldtype],

    data() {
        return {
            searchModalIsOpen: false,
            listType: 'grid',
            query: '',
            result: null,
            loading: false,
            token: this.meta.maveApi,
            theme: this.meta.maveTheme
        };
    },

    computed: {
    },

    methods: {
        openSearchModal() {
            this.searchModalIsOpen = true
        },
        modalOpened() {
            this.$refs.query.$el.querySelector('input').focus()
        }
    }
};
</script>
