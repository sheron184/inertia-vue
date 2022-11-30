<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">
                    <div class="create-student p-3">
                        <div class="flex justify-end">
                            <button class="py-2 px-3 rounded shadow-md border-2 border-indigo-200" data-bs-toggle="collapse" href="#collapseForm" role="button" aria-expanded="false" aria-controls="collapseForm">+ new student</button>
                        </div>
                            <div class="collapse visible" id="collapseForm">
                                <form @submit.prevent="createStudent" class="flex justify-center"> 
                                    <div class="lg:w-1/2 xl:w-1/2 md:w-1/2 sm:w-full shadow-md p-4 mt-2 border rounded-lg">
                                        <div class="form-group p-2">
                                            <label class="my-3">Name</label>
                                            <input v-model="student.name" type="text" name="name" class="form-control" placeholder="Name.." aria-describedby="helpId" required>
                                        </div>
                                        <div class="form-group p-2">
                                            <label class="my-3">Age</label>
                                            <input v-model="student.age" type="number" name="age" class="form-control" placeholder="Name.." aria-describedby="helpId" required>
                                        </div>
                                        <div class="form-group p-2">
                                            <label class="my-3">Status</label>
                                            <select v-model="student.status" name="status" id="" class="form-control">
                                                <option value="active">Active</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>
                                        <div class="form-group p-2">
                                            <label class="my-3">Image</label>
                                            <input @change="setImage" ref="file" type="file" name="name" class="form-control" placeholder="Image.." aria-describedby="helpId" required>
                                        </div>
                                        <div class="form-group p-2 my-2">
                                            <button data-bs-toggle="collapse" href="#collapseForm" type="submit" class="btn btn-sm btn-success">Add</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                   <div class="p-2">
                        <h3 class="text-xl font-bold">Students List</h3>
                        <div class="mt-3">
                            <h5 v-if="student_list.length==0" class="text-red-400">No students yet!</h5>
                            <ul class="students-list pl-0" v-for="student in student_list">
                                <li class="flex items-center student shadow-md p-4 rounded border-gray-700">
                                    <img class="rounded-full shadow-md h-12 w-12 flex items-center justify-center mr-3" :src="'uploads/'+student.image" alt="">
                                    <h5 class="mb-0">{{student.name}}</h5> 
                                    <span class="text-xl mx-3">|</span>
                                    <h5 class="mb-0"> Age - {{student.age}}</h5>
                                    <span class="text-xl mx-3">|</span>
                                    <div>
                                        <h5 class="mb-0" v-if="student.status=='active'">Status - <span class="text-green-500 mb-0">Active</span></h5>
                                        <h5 class="mb-0" v-else> Status - <span class="text-red-500 mb-0">InActive</span></h5>
                                    </div>
                                    <div class="flex flex-grow justify-end">
                                        <Link :href="route('student.edit',student.id)"><font-awesome-icon class="text-yellow-600" icon="fa-solid fa-pen" /></Link>
                                        <button @click="deleteStudent(student.id)" class="ml-3"><font-awesome-icon class="text-red-500" icon="fa-solid fa-trash" /></button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                   </div> 
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { Link } from '@inertiajs/inertia-vue3';
import axios from 'axios';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faTrash,faPen } from '@fortawesome/free-solid-svg-icons';
library.add(faTrash,faPen);

export default{
    components:{
        AuthenticatedLayout,
        Head,
        Link,
        FontAwesomeIcon
    },
    props:{
        students:Array
    },
    data(){
        return {
            student: {
                name: '',
                age:18,
                status:'active',
                image:''
            },
            student_list:[]
        }
    },
    beforeMount(){
        this.student_list = this.students;
    },
    methods:{
        setImage(){
            this.image = this.$refs.file.files[0];
        },
        async createStudent(){
            this.student.image = this.image;
            const headers = { 'Content-Type': 'multipart/form-data' };
            const students =  (await axios.post(route('student.create'),this.student,{headers})).data;
            this.student_list = students.students;
        },
        async deleteStudent(id){
            const newStudents = (await axios.delete(`student/destroy/${id}`)).data;
            this.student_list = newStudents.students;
        }
    }
}
</script>