<template>
     <div class="page-content page-container" id="page-content">
                        <div>
                            <div class="row containe ">
                                <div class="col-md-4">
                                    <ul class="list-group availusers">
                                        <div v-for="u in users">
                                            <li class="list-group-item p-3" @click="fetchMessages(u)" :class="u.id == focusedUser ? 'active' : '' ">
                                                    {{u.name}}
                                            </li>
                                        </div>
                                    </ul>
                                </div>
                                <div class="col-md-8">
                                    <div class="card card-bordered">
                                        <div class="ps-container ps-theme-default ps-active-y" id="chat-content">
                                            <div v-if="messages">
                                                <div v-for="message in messages">
                                                    <div  v-bind:class="[user.id !== message.user.id ? ' media-chat-reverse' : '', 'media','media-chat']">
                                                        <span v-bind:class="[user.id === message.user.id ? 'avgreen' : 'avrose', 'avatar']">
                                                            {{message.user.name[0]}}
                                                        </span>
                                                        <div class="media-body">
                                                            <p v-if="message.message">{{message.message}}</p>
                                                            <div v-if="message.file">
                                                                <a :href="'/storage/chat/'+message.file" target="_blank">
                                                                    <span class="badge badge-primary"><i class="fas fa-paperclip"></i>DOWNLOAD ATTACHMENT</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-show="typing" class="help-block" style="font-style: italic;">
                                                    {{activeUser}} typing...
                                                </div>
                                            </div>
                                        </div>
                                            <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                                <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;">
                                                </div>
                                            </div>
                                            <div class="ps-scrollbar-y-rail" style="top: 0px; height: 0px; right: 2px;">
                                                <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 2px;">
                                                </div>

                                        </div>
                                        </div>
                                        <div v-show="showFilePreview">
                                                <span>{{file.name}}</span>
                                                <span class="rm_chat_file" @click="rm_attachment" title="Click to remove"><i class="fas fa-trash"></i></span>
                                        </div>
                                        <div class="publisher bt-1 border-light" v-show="showForm">
                                            <!-- <span class="avatar avatar-xs avgreen"> {{user.name[0] }}</span> -->
                                             <input class="publisher-input"
                                                    name="message"
                                                    @keydown="isTyping"
                                                    v-model="newMessage"
                                                    @keyup.enter="sendMessage(focusedUser)"
                                                    type="text" placeholder="Write something">
                                             <span class="publisher-btn file-group" @click="browsefile">
                                                <i class="fa fa-paperclip file-browser"></i>
                                                <input type="file" @change="input_changed" id="fileinp" ref="browsefileipnut" name="file">
                                            </span>

                                            <a class="publisher-btn text-info" @click="sendMessage(focusedUser)" href="#" data-abc="true">
                                                <i class="fa fa-paper-plane"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
</template>

<script>

// v-on:messagesentevent="sendMessage"
   export default {
        props:['user'],
        data() {
            return {
                messages : [],
                users : [],
                newMessage: '',
                showFilePreview: false,
                file: '',
                showForm : false,
                focusedUser:null,
                typing: false,
                activeUser:''
            }
        },
        created() {
            this.fetchUsers();
        },

        methods: {
            listenTo(to){
                return Echo.private(`room.${to}`).listen('MessageCreated', (e) => {
                this.messages.push(e.message);
                this.activeUser = '';
                this.typing = false;
            })
            },
            listenForTyping(listener){
                listener.listenForWhisper('typing', response => {
                    this.activeUser = response.user.name;
                    this.typing = response.typing;
                    setTimeout(() => {
                        this.activeUser = '';
                        this.typing = false;
                    }, 2000);
                });
            },
            browsefile(){
                this.$refs.browsefileipnut.click();
            },

            sendMessage(receiver) {
                if (this.file || this.newMessage) {

                    const data = new FormData();
                    data.append('message', this.newMessage);
                    data.append('file', this.file);
                    data.append('room',1);

                    axios.post(`/sendmessage/${receiver}`, data ,{
                        headers: {
                            'Content-Type': 'multipart/form-data',
                        }
                    }).then(response => {
                    });
                } else{
                    alert('write your message')
                }
                this.newMessage = '';
                this.rm_attachment();
            },
            fetchMessages(receiver) {
                axios.get(`/fetchmessages/${receiver.id}`).then(response => {
                    this.messages = response.data;
                });
                this.focusedUser = receiver.id;
                let listener = this.listenTo(1); // join to first room
                this.listenForTyping(listener);
                this.newMessage = '';
                this.showForm = true;
            },
            fetchUsers() {
                axios.get('/fetchusers').then(response => {
                    this.users = response.data;
                });
            },
            input_changed(){
                this.showFilePreview = true;
                this.file = this.$refs.browsefileipnut.files[0];
            },
            rm_attachment(){
                this.file = '';
                this.showFilePreview = false;
            },
            isTyping() {
                setTimeout( () => {
                    Echo.private('room.1').whisper('typing',{
                        user:this.user,
                        typing:true
                    });
                }, 300)
            },

        }
    }
</script>
