<template>
    <div class="container">
        <div class="card">
            <div class="card-header ">
                <h2 class="text-center">المنتجات</h2>
                <div class="row "><div class="text-right col-6 col-sm-4">
                    <router-link to="/create-product">
                        <el-button type="primary" icon="el-icon-edit"> اضافة منتج</el-button>
                    </router-link>
                </div>
                    <div class="text-left col-6 col-sm-8">

                        <el-button type="primary" icon="el-icon-s-operation" data-toggle="collapse" data-target="#collapseExample"
                                   aria-expanded="false" aria-controls="collapseExample"> ترتيب
                        </el-button>
                        <div class="collapse " id="collapseExample" >
                            <div class="card card-body">
                                <el-radio-group v-model="filtering.type"  >
                                    <el-radio label="high" v-on:change="paginate()">السعرالاعلى </el-radio>
                                    <el-radio label="low" v-on:change="paginate()">السعر الاقل</el-radio>
                                    <el-radio label="subCategory" v-on:change="paginate()">حسب الصنف</el-radio>
                                </el-radio-group>

                            </div>
                        </div>
                    </div></div>

            </div>
            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">اسم المنتج</th>
                        <th scope="col">سعر المنتج</th>
                        <th scope="col">صورة المنتج</th>
                        <th scope="col">اسم الصنف الفرعي</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(item,index) in products" v-if="products" :key="index">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>
                            <router-link :to="{ path: '/product-details/'+item.id}" style="color: black;">
                                {{ item.name }}
                            </router-link>
                        </td>
                        <td>{{ item.price }}</td>
                        <td><img v-bind:src="'/images/'+item.image_id" alt="" style="width: 80px; height: 50px"></td>
                        <td>{{ item.sub_category.name }}</td>
                        <td>
                            <router-link :to="{ path: '/edit-product/'+item.id}">
                                <el-button type="success" icon="el-icon-edit">تعديل</el-button>
                            </router-link>
                            <el-button type="danger" icon="el-icon-delete" v-on:click="destroy(item)">حذف</el-button>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class=" paginate ml-5 align-item-center">
                <i class="el-icon-arrow-right" v-on:click="current_page++;paginate();" v-if="current_page!==last_page"></i>
                <span>{{ current_page }}</span>
                <i class="el-icon-arrow-left" v-on:click="current_page--;paginate()" v-if="current_page!==1"></i>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "index-products",
    data() {
        return {
            products: [],
            current_page: 1,
            last_page: 0,
            filtering:{type:null}
        }
    },
    mounted() {
        axios.post('/adminData/products/paginate')
            .then((response) => {
                // handle success
                this.products = response.data.data
                this.last_page = response.data.last_page
                console.log(this.products)
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    },
    methods: {
        succsesful() {
            this.$message({
                message: 'تم الحذف',
                type: 'success'
            });
        },
        destroy(item) {
            axios.delete('/adminData/products/' + item.id)
                .then((response) => {
                    // handle success
                    let index = this.products.indexOf(item)
                    this.products.splice(index, 1)
                    this.succsesful()
                    console.log(this.products)
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },

        paginate() {

            axios.post('/adminData/products/paginate?page=' + this.current_page,this.filtering)
                .then((response) => {
                    // handle success
                    this.products = response.data.data
                    console.log(this.products)

                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },

    }

}
</script>

<style scoped>
.container {
    font-size: 25px;
}
</style>
