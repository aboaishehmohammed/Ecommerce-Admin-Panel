<template>
    <div class="container">
    <b-form @submit="onSubmit"  v-if="category">
        <b-form-group
            label="الاسم:"
        >
            <b-form-input
                v-model="category.name"
                type="text"
                required
            ></b-form-input>
        </b-form-group>

        <b-form-group >
            <b-form-file
                @change="imageChanges($event)"
                accept="image/jpeg, image/png, image/jpg"
            ></b-form-file>

            <div style="width: 100px;height: 100px; position: relative;margin-top: 5px" v-if="category.image_id" >
                <img v-bind:src="category.base64"  alt="" style="height: 100px;" v-if="category.base64">
                <img  alt=""  v-bind:src="'/images/'+category.image_id" style="height: 100px;" v-else>
            </div>
        </b-form-group>
        <b-button type="submit" variant="primary">اختيار</b-button>
    </b-form>
    </div>
</template>

<script>
export default {
    name: "edit-category",
    data() {

        return {
            category:{
            },
        }
    },
    mounted() {
        axios.get('/adminData/categories/' + this.$route.params.category)
            .then((response) => {
                // handle success
                this.category = response.data
                console.log(this.category)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    },

    methods:{

        imageChanges($event) {
            let t = $event.target;
            let files = (t.files)
            console.log(files)
            //this.category.images = [];
            this.category.image_id = files[0]
            console.log(this.category.image_id);

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
            let fd=new FormData();
            fd.append("image",this.category.image_id);
            fd.append("name",this.category.name)
            axios.post('/adminData/categories/'+this.$route.params.category, fd
            )
                .then((response) => {
                    // handle success
                    this.makeToast();
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
