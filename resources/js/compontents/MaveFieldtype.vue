<template>
    <div>
        <div v-if="value" class="mave-relative">
            <mave-player :embed="value"
                class="mave-w-full mave-aspect-video mave-rounded-md mave-overflow-hidden"></mave-player>
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
                        <div name="mave-list-item"
                            class="mave-aspect-video mave-relative mave-rounded-lg mave-bg-stone-100 mave-cursor-pointer mave-overflow-hidden"
                            onclick="document.dispatchEvent(new CustomEvent('mave:select', {detail: this}))">
                            <div slot="item-title"
                                class="mave-w-32 mave-absolute mave-text-xs mave-right-1.5 mave-text-white mave-bottom-1.5 mave-rounded-md mave-bg-black mave-bg-opacity-70 mave-p-1 mave-truncate mave-h-6">
                            </div>
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
            token: this.meta.maveApi
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
