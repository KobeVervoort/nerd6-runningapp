<template>
    <form action="" class="signup-form">

        <input type="text" name="group" placeholder="Search for groups" v-on:keyup = 'getGroups' v-model="input" class="signup-form__input">

        <ul v-if="this.isDisabled == false" class="signup-form__group-list">

            <li v-for="(group, index) in groups" class="signup-form__group" v-on:click = 'selectExisting(group.name, index)'>
                {{group.name}}
            </li>

            <li v-if="this.input!=''" class="signup-form__new-group" v-on:click = "newChosen = true">
                Create new group
                <span class="signup-form__new-group signup-form__new-group--emphasis">
                    {{this.input}}
                </span>
            </li>

        </ul>

        <div v-if="existingChosen == true" class="group-details">

            <h1 class="title">Group Details</h1>

            <p class="normal-text">
                {{groupDetails.description}}
            </p>

            <div class="signup-form__distance">
                <div class="signup-form__label">
                    <img class="signup-form__medal" src="/img/medal-run-blue.png" alt="">
                    <p class="signup-form__distance-label">Target Distance</p>
                </div>
                <p class="signup-form__distance-value">{{groupDetails.target_distance}}km</p>
            </div>

            <div class="signup-form__deadline">
                <div class="signup-form__label">
                    <img class="signup-form__medal" src="/img/medal-speed-blue.png" alt="">
                    <p class="signup-form__deadline-label">Deadline</p>
                </div>
                <p class="signup-form__deadline-value">{{groupDetails.end_date}}</p>
            </div>

            <a href="" class="signup-form__submit" v-on:click.prevent="addExistingGroup">Finish <img src="/img/arrow-blue-right.png" alt="" class="button-arrow" ></a>

        </div>

        <div v-if="newChosen == true" class="group-details">

            <h1 class="title">Group Details</h1>

            <textarea name="description" id="" cols="30" rows="6" placeholder="description" class="signup-form__textarea" v-model="newDescription"></textarea>

            <input type="number" placeholder="Target Distance" class="signup-form__input signup-form__input--padded" v-model="newTarget">

            <input type="text" placeholder="Deadline" class="signup-form__input signup-form__input--padded" onfocus="(this.type='date')" v-model="newDeadline">

            <a href="" class="signup-form__submit" v-on:click.prevent="addNewGroup">Finish <img src="/img/arrow-blue-right.png" alt="" class="button-arrow"></a>

        </div>

    </form>
</template>

<script>

    export default {

        data() {
            return {
                input: '',
                groups: [],
                isDisabled: false,
                existingChosen: false,
                newChosen: false,
                groupDetails: [],
                newDescription: '',
                newTarget: '',
                newDeadline: ''
            }
        },

        methods: {
            getGroups(){
                this.isDisabled = false;
                this.existingChosen = false;
                this.newChosen = false;
                axios.post('/signup/groups', {
                    searchTerm: this.input
                }).then(response => this.groups = response.data)
            },

            selectExisting(group, id){
                this.input = group;
                this.isDisabled = true;
                this.existingChosen = true;
                this.groupDetails = this.groups[id];
            },

            addExistingGroup(){
                axios.post('/signup/existingGroup', {
                    groupID: this.groupDetails.id
                }).then(window.location = '/myProgress')
            },

            addNewGroup(){
                axios.post('signup/newGroup', {
                    name: this.input,
                    description: this.newDescription,
                    target: this.newTarget,
                    deadline: this.newDeadline
                }).then(window.location='/myProgress')
            }
        },

    }

</script>
