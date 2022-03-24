<template>
    <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Get your short url</h3>
                        <p>Fill in the data below.</p>
                        <div v-if="showErrorMessage" class="border-danger border-3 text-center p-2">
                            <p class="m-auto text-center">{{errorMessage}}</p>
                        </div>
                        <form class="requires-validation" novalidate>

                            <div class="col-md-12">
                                <input class="form-control" type="url" name="url" placeholder="Full URL"  v-model="longUrl" required>
                            </div>


                            <div class="form-button mt-3">
                                <button id="submit" type="button" class="btn btn-primary" @click="getUrl" >Get Short Url</button>
                            </div>
                        </form>
                    </div>
                    <div v-if="showLoader" class="lds-ring"><div></div><div></div><div></div><div></div></div>
                    <div v-if="showShortUrl && shortUrl" class="form-items mt-3">
                        <h3>Your Url: </h3> <p>{{shortUrl}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
export default {
    data(){
        return {
            errorMessage: "",
            showErrorMessage: false,
            longUrl: "",
            shortUrl: "",
            showLoader: false,
            showShortUrl:false
    }
    },
    mounted() {
        console.log('Component mounted.')
    },
    methods:{
       getUrl(){
           let vm = this;
           vm.showErrorMessage = false;
           if (vm.longUrl === "" || vm.longUrl === null){
              this.setError("Original url should not be empty!")
               return
           }
           vm.showShortUrl = false;
           vm.showLoader = true;
           axios.post("/api/url/generate", {url: vm.longUrl})
           .then(response => {
                vm.shortUrl = response.data.shortUrl
               vm.showShortUrl = true;
           }, error => {
               if  (error.response.data.errors){
                   this.setError(error.response.data.errors.url[0])
                   return
               }
                this.setError(error.response.data);
           }).finally(()=>{
               vm.showLoader = false;
           })
       },
        setError(errorMessage){
            let vm = this;
            vm.errorMessage = errorMessage;
            vm.showErrorMessage = true;
        }
    }
}
</script>

<style>


.form-body {
    height: 100%;
    background-color: #152733;
    overflow: hidden;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    -webkit-font-smoothing: antialiased;
    text-rendering: optimizeLegibility;
    -moz-osx-font-smoothing: grayscale;
}


.form-holder {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    min-height: 100vh;
}

.form-holder .form-content {
    position: relative;
    text-align: center;
    display: -webkit-box;
    display: -moz-box;
    display: -ms-flexbox;
    display: -webkit-flex;
    display: flex;
    flex-direction: column;
    -webkit-justify-content: center;
    justify-content: center;
    -webkit-align-items: center;
    align-items: center;
    padding: 60px;
}

.form-content .form-items {
    border: 3px solid #fff;
    padding: 40px;
    display: inline-block;
    width: 100%;
    min-width: 540px;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    text-align: left;
    -webkit-transition: all 0.4s ease;
    transition: all 0.4s ease;
}

.form-content h3 {
    color: #fff;
    text-align: left;
    font-size: 28px;
    font-weight: 600;
    margin-bottom: 5px;
}

.form-content h3.form-title {
    margin-bottom: 30px;
}

.form-content p {
    color: #fff;
    text-align: left;
    font-size: 17px;
    font-weight: 300;
    line-height: 20px;
    margin-bottom: 30px;
}


.form-content label, .was-validated .form-check-input:invalid~.form-check-label, .was-validated .form-check-input:valid~.form-check-label{
    color: #fff;
}

.form-content input[type=text], .form-content input[type=password], .form-content input[type=email], .form-content select {
    width: 100%;
    padding: 9px 20px;
    text-align: left;
    border: 0;
    outline: 0;
    border-radius: 6px;
    background-color: #fff;
    font-size: 15px;
    font-weight: 300;
    color: #8D8D8D;
    -webkit-transition: all 0.3s ease;
    transition: all 0.3s ease;
    margin-top: 16px;
}


.btn-primary{
    background-color: #6C757D;
    outline: none;
    border: 0px;
    box-shadow: none;
}

.btn-primary:hover, .btn-primary:focus, .btn-primary:active{
    background-color: #495056;
    outline: none !important;
    border: none !important;
    box-shadow: none;
}

.form-content textarea {
    position: static !important;
    width: 100%;
    padding: 8px 20px;
    border-radius: 6px;
    text-align: left;
    background-color: #fff;
    border: 0;
    font-size: 15px;
    font-weight: 300;
    color: #8D8D8D;
    outline: none;
    resize: none;
    height: 120px;
    -webkit-transition: none;
    transition: none;
    margin-bottom: 14px;
}

.form-content textarea:hover, .form-content textarea:focus {
    border: 0;
    background-color: #ebeff8;
    color: #8D8D8D;
}





.lds-ring {
    display: inline-block;
    position: relative;
    width: 80px;
    height: 80px;
}
.lds-ring div {
    box-sizing: border-box;
    display: block;
    position: absolute;
    width: 64px;
    height: 64px;
    margin: 8px;
    border: 8px solid #fff;
    border-radius: 50%;
    animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
    border-color: #fff transparent transparent transparent;
}
.lds-ring div:nth-child(1) {
    animation-delay: -0.45s;
}
.lds-ring div:nth-child(2) {
    animation-delay: -0.3s;
}
.lds-ring div:nth-child(3) {
    animation-delay: -0.15s;
}
@keyframes lds-ring {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}
</style>
