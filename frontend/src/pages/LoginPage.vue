<template>
  <div class="flex items-center justify-center min-h-screen relative bg-cover bg-center bg-no-repeat bg-background">
    <!-- login card -->
    <div class="bg-[#F2F6FF] shadow-xl rounded-3xl p-8 max-w-xs w-full z-10 relative">
      <h1 class="text-2xl font-bold text-center mb-6 text-[#1F41BB]">Login Here</h1>
      
      <!-- form -->
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <input
            type="username"
            id="username"
            v-model="username"
            required
            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-[#1F41BB] focus:border-[#1F41BB] focus:outline-none"
            placeholder="Username"
          />
        </div>
        <div class="mb-4">
          <input
            type="password"
            id="password"
            v-model="password"
            required
            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-[#1F41BB] focus:border-[#1F41BB] focus:outline-none"
            placeholder="Password"
          />
        </div>
        
        <!-- forgot password -->
        <div class="text-right mb-4">
          <a href="#" class="text-sm text-[#1F41BB] hover:underline">Forgot your password?</a>
        </div>
        
        <!-- sign in button -->
        <button
          type="submit"
          class="w-full bg-[#1F41BB] text-white py-2 px-4 rounded-lg hover:bg-[#1f41bbe3] transition-colors shadow-md"
        >
          Sign in
        </button>
        
        <!-- divider -->
        <div class="text-center my-4">
          <span class="block w-full border-t border-gray-300"></span>
          <p class="text-sm text-gray-500 mt-4">Or continue with</p>
        </div>

        <!-- social buttons -->
        <div class="flex justify-center gap-4 mt-4">
          <button class="bg-white border rounded-full p-2 shadow hover:bg-gray-100">
            <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google" class="w-6 h-6"/>
          </button>
          <button class="bg-white border rounded-full p-2 shadow hover:bg-gray-100">
            <img src="https://img.icons8.com/ios-filled/50/000000/facebook-new.png" alt="Facebook" class="w-6 h-6"/>
          </button>
          <button class="bg-white border rounded-full p-2 shadow hover:bg-gray-100">
            <img src="https://img.icons8.com/ios-filled/50/000000/mac-os.png" alt="Apple" class="w-6 h-6"/>
          </button>
        </div>

        <!-- create account -->
        <div class="text-center mt-6">
          <router-link  
            to="/register"  
            class="w-full bg-gray-100 text-black py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors"
          >
            Create new account
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
import { useToast } from 'vue-toastification';

//initialize toast
const toast = useToast();

const username = ref('');
const password = ref('');
const router = useRouter(); //initialize the router

const handleLogin = async () => {
  try {
    const response = await axios.post('http://localhost/SystemSecured/backend/app/Controllers/AuthController.php',
      new URLSearchParams({
        username: username.value,
        password: password.value,
        action: 'login'
      })
    );

    if (response.data.status === 'success') {
      localStorage.setItem('isLoggedIn', true);
      localStorage.setItem('user', JSON.stringify(response.data.user));
      toast.success(response.data.message);
      router.push('/home');
    } else {
      toast.error(response.data.message, { toastClassName: 'toast-error' });
    }
  } catch (error) {
    toast.error('Error login');
    console.error(error);
  }
}

</script>

<style scoped>
.bg-background {
  background-image: url('@/assets/background.png');
  background-size: cover;
  background-position: center;
}
</style>
