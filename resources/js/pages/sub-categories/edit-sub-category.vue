<template>
    <div class="container">
    <b-form @submit="onSubmit"  >
        <b-form-group
            label="اسم الصنف الفرعي">
            <b-form-input
                v-model="sub_category.name"
                type="text"
                required
            ></b-form-input>
        </b-form-group>

        <b-form-group label="صورة الصنف الفرعي">
            <b-form-file
                @change="imageChanges($event)"
                accept="image/jpeg, image/png, image/jpg"
            ></b-form-file>
            <div style="width: 100px;height: 100px; position: relative;margin-top: 5px" v-if="sub_category.image_id" >
                <img v-bind:src="sub_category.base64"  alt="" style="height: 100px;" v-if="sub_category.base64">
                <img  alt=""  v-bind:src="'/images/'+sub_category.image_id" style="height: 100px;" v-else>
            </div>
        </b-form-group>
        <b-form-group label="اختيار الصنف الرئيسي">
            <b-form-select v-model="sub_category.category_id" class="mb-3" required>
                <b-form-select-option v-for="(item,index) in categories" :value="item.id" :key="index">{{item.name}}</b-form-select-option>
            </b-form-select>        </b-form-group>
        <b-button type="submit" variant="primary">Submit</b-button>
    </b-form></div>
</template>

<script>
export default {
    name: "edit-sub-category",
    data() {

        return {
            categories:{},

            sub_category:{

            },
        }
    },
    mounted() {
        axios.get('/adminData/sub-categories/'+this.$route.params.sub_category )
            .then((response) => {
                // handle success
                this.sub_category = response.data
                console.log(this.sub_category)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });

        axios.get('/adminData/categories/' )
            .then((response) => {
                // handle success
                this.categories = response.data
                console.log(this.categories)
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
            this.sub_category.image_id = files[0]
            console.log(this.sub_category.image_id);

            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            reader.onloadend = () => {
                Vue.set(this.sub_category, 'base64', reader.result);
                console.log("FILE:", reader.result, this.sub_category);
            }

            console.log(this.sub_category)
        },


        onSubmit: function (evt) {
            evt.preventDefault();
            let fd=new FormData();
            fd.append("image",this.sub_category.image);
            fd.append("name",this.sub_category.name)
            fd.append("category_id",this.sub_category.category_id)
            axios.post('/adminData/sub-categories/'+this.$route.params.sub_category, fd
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
