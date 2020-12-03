<template>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h2 class="text-center">التصنيفات الرئيسية</h2>
                <div class="text-right">
                    <router-link to="/create-category">
                        <el-button type="primary" icon="el-icon-edit"> اضافة صنف</el-button>
                    </router-link>
                </div>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col"></th>
                        <th scope="col">صورة الصنف</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(item,index) in categories" v-if="categories" :key="index">
                        <th scope="row">{{ index + 1 }}</th>
                        <td>
                            <router-link :to="{ path: '/details/'+item.id}" style="color: black;">
                                {{ item.name }}
                            </router-link>
                        </td>
                        <td><img v-bind:src="'/images/'+item.image_id" alt="" style="width: 80px; height: 50px"></td>
                        <td>
                            <router-link :to="{ path: '/edit-category/'+item.id}">
                                <el-button type="success" icon="el-icon-edit">تعديل</el-button>
                            </router-link>
                            <el-button type="danger" icon="el-icon-delete" v-on:click="destroy(item)">حذف</el-button>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <div class=" paginate ml-5 align-item-center" >
                <i class="el-icon-arrow-right" v-on:click="paginate('next')" v-if="current_page!==last_page"></i>
                <span>{{current_page}}</span>
                <i  class="el-icon-arrow-left" v-on:click="paginate('previous')" v-if="current_page!==1"></i>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "index-categories",
    data() {
        return {
            categories: [],
            current_page: 1,
            last_page:0
        }
    },
    mounted() {
        axios.get('/adminData/categories/paginate')
            .then((response) => {
                // handle success
                this.categories = response.data.data
                this.last_page=response.data.last_page
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
    methods: {
        succsesful() {
            this.$message({
                message: 'تم الحذف',
                type: 'success'
            });
        },
        destroy(item) {
            axios.delete('/adminData/categories/' + item.id)
                .then((response) => {
                    // handle success
                    let index = this.categories.indexOf(item)
                    this.categories.splice(index, 1)
                    console.log(this.categories)
                    this.succsesful()
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
                .then(function () {
                    // always executed
                });
        },
        paginate(page) {
            if(page==='next'){
                this.current_page++
            }else
                this.current_page--
            axios.get('/adminData/categories/paginate?page='+this.current_page)
                .then((response) => {
                    // handle success
                    this.categories = response.data.data
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

    }

}
</script>

<style scoped>

</style>
