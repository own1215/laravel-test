<template>
    <div>
        <v-layout row wrap>
            <v-flex xs6
                    v-for="image in imageList"
                    :key="image.id"
                    class="image-block"
            >
                <v-card class="mx-auto"
                        width="344"
                >
                    <v-img
                            :aspect-ratio="16/9"
                            :src="image.path"
                    ></v-img>
                    <v-card-title>
                        <div>
                            <div class="d-flex">
                                <div class="ml-2 grey--text text--darken-2">
                                    <div>Size: {{ image.size }}</div>
                                    <div>Extension: ({{ image.extension }})</div>
                                </div>
                            </div>
                        </div>
                    </v-card-title>
                </v-card>
            </v-flex>
        </v-layout>
    </div>
</template>

<script>
    export default {
        name: "FrontImageList",
        props: [
            'images',
        ],
        data() {
            return {
                imageList: this.images,
            }
        },
        mounted() {
            console.log(this.imageList);
        }
    }
</script>

<style scoped>
    .image-block {
        padding-bottom: 20px;
    }
</style>