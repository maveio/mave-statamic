<template>
  <div>
    <div v-if="value" class="mave-relative">
      <mave-player :embed="value"
        class="mave-w-full mave-aspect-video mave-rounded-md mave-overflow-hidden" :theme="theme" :style="{ 'background': 'url(//space-' + value.substr(0, 5) + '.video-dns.com/' + value.substr(5, 14) + '/poster.jpg) center center / contain no-repeat' }"></mave-player>
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

    <stack v-if="modalIsOpen" @closed="modalIsOpen = false">
      <div slot-scope="{ close }" class="mave-flex mave-flex-col mave-h-full mave-bg-white">

        <header
          class="bg-white pl-6 pr-3 py-2 mb-4 border-b shadow-md text-lg font-medium flex items-center justify-between">
          Select a video
          <button type="button" class="btn-close" @click="modalIsOpen = false; uploadIsActive = false;">×</button>
        </header>

        <div class="mave-px-6 mave-py-3 mave-flex-1 mave-flex mave-flex-col mave-overflow-y-scroll">

          <div name="mave-list-upload" class="mave-grid mave-w-full mave-grid-cols-5 mave-gap-3 mave-mb-3" v-if="upload && !uploadIsActive">
            <div class="relative mave-aspect-video mave-relative mave-rounded-lg mave-border mave-border-stone-100" @click="openUpload">
              <div class="mave-w-full mave-h-full mave-flex mave-flex-col mave-items-center mave-justify-center mave-text-3xl mave-font-bold mave-text-stone-400/70 mave-cursor-pointer" slot="root-link">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.1" stroke="currentColor" class="mave-w-8 mave-h-8">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0 3 3m-3-3-3 3M6.75 19.5a4.5 4.5 0 0 1-1.41-8.775 5.25 5.25 0 0 1 10.233-2.33 3 3 0 0 1 3.758 3.848A3.752 3.752 0 0 1 18 19.5H6.75Z" />
                </svg>
                <div class="mave-text-xs mave-text-stone-400/90 mave-font-medium mave-mt-1">upload video</div>
              </div>
            </div>
          </div>

          <mave-list class="mave-grid mave-w-full mave-grid-cols-5 mave-gap-3" v-bind:token="token" v-if="!uploadIsActive">
            <div name="mave-list-root" class="relative mave-aspect-video mave-relative mave-rounded-lg mave-border mave-border-stone-100">
              <div class="mave-w-full mave-h-full mave-flex mave-items-center mave-justify-center mave-text-3xl mave-font-bold mave-text-stone-400 mave-cursor-pointer" slot="root-link">
                <div class="mave-mb-4">...</div>
              </div>
            </div>
            <div name="mave-list-folder" class="relative mave-aspect-video mave-relative mave-rounded-lg mave-bg-stone-100">
              <div class="mave-w-full mave-h-full mave-cursor-pointer" slot="folder-link">
                <div class="mave-absolute mave--top-1.5 mave-w-8 mave-h-4 mave-bg-stone-100 mave-rounded-lg"></div>
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

          <div v-if="uploadIsActive">
            <mave-upload ref="uploadComponent" v-bind:token="token" class="mave-border mave-border-stone-100 mave-rounded-lg"></mave-upload>
          </div>

        </div>        

      </div>
    </stack>

  </div>
</template>

<script>
import "https://cdn.video-dns.com/npm/@maveio/components/+esm";

export default {
  mounted() {
    document.addEventListener('mave:select', this.handleMaveSelect.bind(this));
  },
  
  beforeUnmount() {
    document.removeEventListener('mave:select', this.handleMaveSelect.bind(this));
  },

  mixins: [Fieldtype],

  data() {
    return {
      modalIsOpen: false,
      uploadIsActive: false,
      listType: 'grid',
      query: '',
      result: null,
      loading: false,
      token: this.meta.maveApi,
      theme: this.meta.maveTheme,
      upload: this.meta.maveUpload,
    };
  },

  methods: {
    handleMaveSelect(e) {
      if (this.modalIsOpen) {
        const embed = e.detail && e.detail.embed || e.detail.querySelector('mave-img').getAttribute('embed');
        this.update(embed);
        this.modalIsOpen = false;
        this.uploadIsActive = false;
      }
    },
    openSearchModal() {
      this.modalIsOpen = true;
    },
    openUpload() {
      this.uploadIsActive = true;
      setTimeout(this.showUpload.bind(this), 100);
    },
    showUpload() {
      const uploadComponent = this.$refs.uploadComponent;
      if (uploadComponent) {
        uploadComponent.addEventListener('completed', this.handleMaveSelect.bind(this));
      }
    },
  },
};

</script>
