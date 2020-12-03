<template>
    <div class="container">
    <b-form @submit="onSubmit"  >
        <b-form-group
            label="اسم المنتج">
            <b-form-input
                v-model="product.name"
                type="text"
                required
            ></b-form-input>
        </b-form-group>
        <b-form-group
            label="وصف المنتج">
            <b-textarea
                v-model="product.description"
                rows="3"
                max-rows="10"
                required
            ></b-textarea>
        </b-form-group>
        <b-form-group
            label="الكمية المتوفرة">
            <b-form-input
                v-model="product.qty"
                type="number"
                min="0"
                required
            ></b-form-input>
        </b-form-group>
        <b-form-group
            label="سعر المنتج">
            <b-form-input
                v-model="product.price"
                type="number"
                min="0"
                required
            ></b-form-input>
        </b-form-group>

        <b-form-group label="صورة المنتج">
            <b-form-file
                v-model="product.image_id"
                @change="imageChanges($event)"
                accept="image/jpeg, image/png, image/jpg"

            ></b-form-file>
            <div style="width: 100px;height: 100px; position: relative;margin-top: 5px" v-if="product.image_id" >
                <img v-bind:src="product.base64"  alt="" style="height: 100px;" v-if="product.base64">
                <img  alt=""  v-bind:src="'/images/'+product.image_id" style="height: 100px;" v-else>
            </div>
        </b-form-group>
        <b-form-group label="اختيار الصنف ">
            <b-form-select v-model="product.sub_category_id" class="mb-3" required>
                <b-form-select-option v-for="(item,index) in sub_categories" :value="item.id" :key="index">{{item.name}}</b-form-select-option>

            </b-form-select>        </b-form-group>
        <b-button type="submit" variant="primary">تعديل</b-button>
    </b-form>
    </div>
</template>

<script>
export default {
    name: "edit-product",
    data() {

        return {
            sub_categories:null,
            product:{
            },
        }
    },
    mounted() {
        axios.get('/adminData/products/' + this.$route.params.product)
            .then((response) => {
                // handle success
                this.product = response.data
                console.log(this.product)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
        axios.get('/adminData/sub-categories/' )
            .then((response) => {
                // handle success
                this.sub_categories = response.data
                console.log(this.sub_categories)
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
            this.product.image_id = files[0]
            console.log(this.product.image_id);

            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            reader.onloadend = () => {
                Vue.set(this.product, 'base64', reader.result);
                console.log("FILE:", reader.result, this.product);
            }

            console.log(this.product)
        },

        onSubmit: function (evt) {
            evt.preventDefault();
            let fd=new FormData();
            fd.append("image",this.product.image_id);
            fd.append("name",this.product.name);
            fd.append("description",this.product.description),
                fd.append("qty",this.product.qty),
                fd.append("price",this.product.price)
            fd.append("sub_category_id",this.product.sub_category_id)
            axios.post('/adminData/products/'+this.$route.params.product, fd
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
