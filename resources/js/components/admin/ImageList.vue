<template>
    <div>
        <v-content>
            <v-container fluid>
                <v-flex xs12 class="text-xs-center text-sm-center text-md-center text-lg-center">
                    <img :src="imageUrl" height="150" v-if="imageUrl"/>
                    <v-text-field label="Select Image" @click='pickFile' v-model='imageName' prepend-icon='attach_file'></v-text-field>
                    <input
                            type="file"
                            style="display: none"
                            ref="image"
                            accept="image/*"
                            @change="onFilePicked"
                    >
                </v-flex>
            </v-container>
        </v-content>

        <v-layout>
            <v-flex xs12 >
                <v-card>
                    <v-container grid-list-m fluid>
                        <v-layout row wrap>
                            <v-flex
                                    v-for="image in imageList"
                                    :key="image.id"
                                    xs4
                                    d-flex
                            >
                                <v-card flat tile class="d-flex">
                                    <v-img
                                            :src="image.path"
                                            :lazy-src="image.path"
                                            aspect-ratio="1"
                                            class="grey lighten-2"
                                            @click="editImage(image)"
                                    >
                                        <v-layout
                                                slot="placeholder"
                                                fill-height
                                                align-center
                                                justify-center
                                                ma-0
                                        >
                                            <v-progress-circular indeterminate color="grey lighten-5"></v-progress-circular>
                                        </v-layout>
                                    </v-img>
                                </v-card>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
            </v-flex>
        </v-layout>

        <v-dialog
                v-model="dialog"
                width="500"
        >
            <v-card>
                <v-card-title class="headline grey lighten-2" primary-title>
                    Edit Image
                </v-card-title>

                <v-card-text>
                    <v-checkbox v-for="user in userList"
                                v-model="currentImage.users"
                                :label="user.name"
                                :value="user.id"
                                :key="user.id"
                    ></v-checkbox>
                </v-card-text>

                <v-divider></v-divider>

                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="primary"
                           flat
                           @click="saveImage"
                    >Save</v-btn>
                    <v-btn color="primary"
                           flat
                           @click="cancel"
                    >Cancel</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
    export default {
        name: "ImageList",
        props:[
            'images',
            'users',
        ],
        data () {
            return {
                imageList: this.images,
                userList: this.users,
                dialog: false,
                imageName: '',
                imageUrl: '',
                imageFile: '',
                currentImage: {
                    id: null,
                    users: [],
                }
            }
        },
        methods: {
            editImage(props) {
                this.currentImage = {
                    id: props.id,
                    users: props.users.map(item => item.id),
                };
                this.dialog = true;
            },
            pickFile () {
                this.$refs.image.click();
            },
            async onFilePicked (e) {
                const files = e.target.files;

                if(files[0] !== undefined) {
                    let fileData = new FormData();

                    fileData.append('image', files[0]);

                    const config = {
                        headers: { 'content-type': 'multipart/form-data' }
                    };

                    try {
                        const {data} = await axios.post('/admin/images', fileData, config);
                        this.imageList = data;
                    } catch(e) {}

                } else {
                    this.imageName = '';
                    this.imageFile = '';
                    this.imageUrl = '';
                }
            },
            async saveImage() {
                let {users} = this.currentImage;

                try {
                    let {data} = await axios.put(`/admin/images/${this.currentImage.id}`, {users});
                    this.imageList = data;
                    this.setDefaultCurImage();
                    this.dialog = false;
                } catch(e) {}
            },
            cancel() {
                this.dialog = false;
                this.setDefaultCurImage();
            },
            setDefaultCurImage() {
                this.currentImage = {
                    id: null,
                    users: [],
                }
            },
        },
    }
</script>

<style scoped>
    .errors {
        color: red;
    }
</style>