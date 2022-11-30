<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Student</h2>
        </template> 
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 my-5">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div>
                        <form @submit.prevent="updateStudent" class="flex justify-center"> 
                                    <div class="lg:w-1/2 xl:w-1/2 md:w-1/2 sm:w-full shadow-md p-4 mt-2 border rounded-lg">
                                        <div class="pt-2">
                                            <h4>Edit Student</h4>
                                        </div>
                                        <div class="form-group p-2">
                                            <label class="my-3">Name</label>
                                            <input v-model="editedStudent.name" type="text" name="name" class="form-control" placeholder="Name.." aria-describedby="helpId" required>
                                        </div>
                                        <div class="form-group p-2">
                                            <label class="my-3">Age</label>
                                            <input v-model="editedStudent.age" type="number" name="age" class="form-control" placeholder="Name.." aria-describedby="helpId" required>
                                        </div>
                                        <div class="form-group p-2">
                                            <label class="my-3">Status</label>
                                            <select v-model="editedStudent.status" name="status" id="" class="form-control">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group p-2">
                                            <label class="my-3">Image</label>
                                            <input @change="setImage" ref="file" type="file" name="name" class="form-control" placeholder="Image.." aria-describedby="helpId">
                                        </div>
                                        <div class="form-group p-2 my-2">
                                            <button v-if="!loading" type="submit" class="btn-sm bg-amber-500 text-white py-2 px-3 rounded hover:bg-amber-700">Update</button>
                                            <div v-else class="bg-blue-300 w-fit py-2 px-3 rounded flex items-center text-white">Updating..
                                                <div class="spinner-border spinner-border-sm text-primary ml-2" role="status"></div>
                                            </div>
                                        </div>
                                    </div>
                        </form>
                    </div>
                </div>
            </div>
    </AuthenticatedLayout>
</template>

<script>
//console.log(student)
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';

export default{
    components:{
        AuthenticatedLayout,
        Head
    },
    props:{
        student:Object
    },
    beforeMount(){
        console.log(this.student.name);
    },
    data(){
        return {
            editedStudent: {
                id:this.student.id,
                name: this.student.name,
                age:this.student.age,
                status:this.student.status,
                image:''
            },
            loading:false
        }
    },
    methods:{
        setImage(){
            this.image = this.$refs.file.files[0];
        },
        async updateStudent(){
            this.loading = true;

            this.editedStudent.image = this.image;

            const headers = { 'Content-Type': 'multipart/form-data' };
            await axios.post(route('student.update'),this.editedStudent,{headers}).then(function(response){
                Inertia.visit(route('dashboard'), { method: 'get'});
            }).catch(function(error){
                console.log(error);
            });
            
        }
    }
}
</script>