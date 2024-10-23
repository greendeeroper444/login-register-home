<template>
  <div class="flex items-center justify-center min-h-screen relative bg-cover bg-center bg-no-repeat bg-background">
    <!-- login card -->
    <div class="bg-[#F2F6FF] shadow-xl rounded-3xl p-8 max-w-xs w-full z-10 relative">
      <h1 class="text-2xl font-bold text-center mb-6 text-[#1F41BB]">Create Account</h1>

      <!-- form -->
      <form @submit.prevent="handleRegister">
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
            @input="updateStrength"
            required
            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-[#1F41BB] focus:border-[#1F41BB] focus:outline-none"
            placeholder="Password"
          />
          <p class="text-sm mt-2" :class="strengthClass">
            {{ passwordStrength }}
          </p>
        </div>

        <div class="mb-4">
          <input
            type="password"
            id="confirmPassword"
            v-model="confirmPassword"
            required
            class="mt-1 block w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-[#1F41BB] focus:border-[#1F41BB] focus:outline-none"
            placeholder="Confirm Password"
          />
        </div>

        <!-- Password Requirements -->
        <ul class="text-xs text-gray-600 mt-2 mb-4">
          <li :class="password.length >= 8 ? 'text-green-500' : 'text-red-500'">✓ At least 8 characters length</li>
          <li :class="containsNumber(password) ? 'text-green-500' : 'text-red-500'">✓ At least 1 number (0...9)</li>
          <li :class="containsSpecialChar(password) ? 'text-green-500' : 'text-red-500'">✓ At least 1 special symbol (!...$)</li>
          <li :class="containsLowercase(password) ? 'text-green-500' : 'text-red-500'">✓ At least 1 lowercase letter (a...z)</li>
          <li :class="containsUppercase(password) ? 'text-green-500' : 'text-red-500'">✓ At least 1 uppercase letter (A...Z)</li>
        </ul>


        <!-- sign up button -->
        <button
          type="submit"
          class="w-full bg-[#1F41BB] text-white py-2 px-4 rounded-lg hover:bg-[#1f41bbe3] transition-colors shadow-md"
        >
          Sign up
        </button>

        <!-- login account -->
        <div class="text-center mt-6">
          <router-link
            to="/"
            class="w-full bg-gray-100 text-black py-2 px-4 rounded-lg hover:bg-gray-200 transition-colors"
          >
            Already have an account
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
import { evaluatePasswordStrength, validatePassword } from '@/utils/passwordValidation';

// initialize toast
const toast = useToast();

const username = ref('');
const password = ref('');
const confirmPassword = ref('');
const passwordStrength = ref('');
const strengthClass = ref('');
const router = useRouter(); // initialize the router

const containsNumber = (password) => /\d/.test(password);
const containsSpecialChar = (password) => /[!@#$%^&*(),.?":{}|<>]/.test(password);
const containsLowercase = (password) => /[a-z]/.test(password);
const containsUppercase = (password) => /[A-Z]/.test(password);

const updateStrength = () => {
  const strengthsText = 'Strength:' ;
  const strength = evaluatePasswordStrength(password.value);
  passwordStrength.value = strength.charAt(0).toUpperCase() + strength.slice(1);
  strengthClass.value = strength === `${strengthsText} weak` ? 'text-red-500' : strength === `${strengthsText} medium` ? 'text-yellow-500' : 'text-green-500';
};

const handleRegister = async () => {
  if (password.value !== confirmPassword.value) {
    toast.error('Passwords do not match!', { toastClassName: 'toast-error' });
    return;
  }

  if (!validatePassword(password.value)) {
    toast.error('Password must meet the security requirements.', { toastClassName: 'toast-error' });
    return;
  }

  try {
    const response = await axios.post(
      'http://localhost/SystemSecured/backend/app/Controllers/AuthController.php',
      new URLSearchParams({
        username: username.value,
        password: password.value,
        action: 'register'
      })
    );

    //handle success or error response
    if (response.data.status === 'success') {
      toast.success(response.data.message);
      // router.push('/');
    } else {
      toast.error(response.data.message, { toastClassName: 'toast-error' });
    }
  } catch (error) {
    toast.error('Error registering');
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
