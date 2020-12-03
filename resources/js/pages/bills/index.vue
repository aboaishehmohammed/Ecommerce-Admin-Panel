<template>
    <div>
        <div class="card">
            <div class="card-header">

                <h2 class="text-center">الفواتير</h2>
            </div>
            <div class="card-body" style="overflow-x:auto;">
                <table class="table table-hover" >
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">اسم العميل</th>
                        <th scope="col">الايميل</th>
                        <th scope="col">المبلغ</th>
                        <th scope="col">الحالة</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr v-for="(item,index) in bills" v-if="bills" :key="index">
                        <th scope="row">{{index+1}}</th>
                        <td>{{item.user.name}}</td>
                        <td>{{item.user.email}}</td>
                        <td>{{ item.total }}</td>
                        <td v-if="item.order_status">تم التوصيل</td>
                        <td v-if="!item.order_status">لم يتم التوصيل</td>
                        <td>        <router-link :to="{ path: '/bill-details/'+item.id}"> <el-button type="success" icon="el-icon-s-order
">التفاصيل </el-button>
                    </router-link>
                            <el-button v-if="!item.order_status" type="danger" icon="el-icon-truck" v-on:click="orderDone(item)">التوصيل</el-button>
                        </td>
                    </tr>
                    </tbody>
                </table>            </div>

        </div>
    </div>
</template>

<script>
export default {
    name: "index-bills",
    data() {
        return {
            bills: [],
        }
    },
    mounted() {
        axios.get('/adminData/bills/')
            .then((response) => {
                // handle success
                this.bills = response.data
                console.log(this.bills)
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
        orderDone (item) {
            axios.post('/adminData/bills/order/'+item.id)
                .then((response) => {
                    this.succsesful()
                    item.order_status=true
                })
                .catch(function (error) {
                    console.log(error);
                })
                .then(function () {
                });
        },
        succsesful() {
            this.$message({
                message: 'تم التوصيل',
                type: 'success'
            });
        },
    },

}
</script>

<style scoped>

</style>
