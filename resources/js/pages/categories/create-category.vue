<template>
    <div class="container">
        <b-form @submit="onSubmit">
            <b-form-group
                label="اسم الصنف الرئيسي"
            >
                <b-form-input
                    v-model="category.name"
                    type="text"
                    required
                ></b-form-input>
            </b-form-group>

            <b-form-group label="صورة الصنف الرئيسي">
                <b-form-file
                    @change="imageChanges($event)"
                    accept="image/jpeg, image/png, image/jpg"
                    required
                ></b-form-file>
                <div style="width: 100px;height: 100px; position: relative;margin-top: 5px" v-if="category.image">
                    <img v-bind:src="category.base64" alt="" style="height: 100px;">
                </div>
            </b-form-group>
            <b-button type="submit" variant="primary">اضافة</b-button>
        </b-form>
    </div>
</template>

<script>
export default {
    name: "create-category",
    data() {

        return {
            category: {

                name: '',
                image: null
            },
        }
    },

    methods: {
        imageChanges($event) {
            let t = $event.target;
            let files = (t.files)
            console.log(files)
            //this.category.images = [];
            this.category.image = files[0]
            console.log(this.category.image);

            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            reader.onloadend = () => {
                Vue.set(this.category, 'base64', reader.result);
                console.log("FILE:", reader.result, this.category);
            }

            console.log(this.category)
        },


        onSubmit: function (evt) {
            evt.preventDefault();
            let fd = new FormData();
            fd.append("image", this.category.image);
            fd.append("name", this.category.name)
            axios.post('/adminData/categories/', fd
            )
                .then((response) => {
                    // handle success
                    console.log(response)
                    this.$router.push('/')

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {

                    // always executed
                });
        }
    }

}
</script>

<style scoped>

</style>
