<template>
    <div class="col-md-8 my-5">
        <div class="text-center">
            <h1 class="display-1">ย่อลิ้งค์</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-10 px-3 pl-xl-0">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="link">ลิ้งค์</span>
                        </div>
                        <input type="url" class="form-control form-control-lg" name="link" id="link" v-model="link"
                            placeholder="https://example.com" autocomplete="off">
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="password">รหัสผ่าน</span>
                        </div>
                        <input type="password" class="form-control form-control-sm" name="password" id="password"
                            v-model="password" placeholder="รหัสผ่าน">
                    </div>
                </div>
            </div>
            <div class="col-12 col-xl-2 px-3 px-xl-0 pb-3">
                <button class="btn btn-block btn-success h-100" v-on:click="onSubmit" :disabled="!link">ย่อลิ้งค์</button>
            </div>
        </div>
        <div class="row" v-if="status">
            <div class="col-xl-12">
                <hr>
                <div class="row">
                    <div class="col-12 col-xl-8">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" v-model="url">
                            <div class="input-group-append">
                                <button class="btn btn-outline-dark" v-on:click="onClickCopy">คัดลอก</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4">
                        <vue-qrcode v-model="url" errorCorrectionLevel="M" type="image/webp" width="220" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import VueQrcode from 'vue-qrcode';

    export default {
        components: {
            VueQrcode,
        },
        data() {
            return {
                link: null,
                password: null,
                url: null,
                status: false
            }
        },
        methods: {
            onSubmit() {
                axios.defaults.headers.common = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                };
                axios.post('/api/shorturl', {
                    link: this.link,
                    password: this.password
                }).then((response) => {
                    let result = response.data;
                    this.status = result.status;
                    this.url = result.data;

                    this.link = null;
                    this.password = null;
                });
            },
            onClickCopy () {
                this.$clipboard(this.url);
                this.$toasted.show('คัดลอกลิ้งค์ เรียบร้อย!', {
                    position: 'bottom-center',
                    duration: 5000
                });
            },
            checkForm () {
                return this.url != null ? false : true;
            }
        },
        mounted() {
            console.log('Start');
        }
    }

</script>
