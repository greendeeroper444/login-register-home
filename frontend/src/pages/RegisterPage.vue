<template>
  <div class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-sm">
      <h1 class="text-2xl font-bold text-center mb-6">Register</h1>
      <form @submit.prevent="handleRegister">
        <div class="mb-4">
          <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
          <input
            type="text"
            id="username"
            v-model="username"
            required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#009578] focus:border-[#009578]"
            placeholder="Enter your username"
          />
        </div>
        <div class="mb-4">
          <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
          <input
            type="password"
            id="password"
            v-model="password"
            required
            @input="updateStrength"
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#009578] focus:border-[#009578]"
            placeholder="Enter your password"
          />
          <div class="mt-2">
            <span :class="strengthClass">{{ passwordStrength }}</span>
          </div>
        </div>
        <div class="mb-4">
          <label for="confirmPassword" class="block text-sm font-medium text-gray-700">Confirm Password</label>
          <input
            type="password"
            id="confirmPassword"
            v-model="confirmPassword"
            required
            class="mt-1 block w-full p-2 border border-gray-300 rounded-md shadow-sm focus:ring-[#009578] focus:border-[#009578]"
            placeholder="Confirm your password"
          />
        </div>
        <div class="flex justify-between items-center mb-4">
          <a href="#" class="text-sm text-[#009578] hover:underline">Forgot password?</a>
        </div>
        <button
          type="submit"
          class="w-full bg-[#009578] text-white py-2 px-4 rounded-md hover:bg-[#007f61] transition-colors"
        >
          Sign up
        </button>
        <div class="text-center mt-4">
          <p class="text-sm text-gray-600">Don't have an account? <a href="/" class="text-[#009578] hover:underline">Sign up</a></p>
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

//initialize toast
const toast = useToast();

const username = ref('');
const password = ref('');
const confirmPassword = ref('');
const passwordStrength = ref('');
const strengthClass = ref('');
const router = useRouter(); //initialize the router

const updateStrength = () => {
  const strength = evaluatePasswordStrength(password.value);
  passwordStrength.value = strength.charAt(0).toUpperCase() + strength.slice(1);
  strengthClass.value = strength === 'weak' ? 'text-red-500' : strength === 'medium' ? 'text-yellow-500' : 'text-green-500'; // Set color based on strength
};

const handleRegister = async () => {
  if (password.value !== confirmPassword.value) {
    toast.error('Passwords do not match!');
    return;
  }

  if (!validatePassword(password.value)) {
    toast.error('Password must be at least 8 characters long, contain upper and lower case letters, numbers, and symbols.');
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
      router.push('/');
    } else {
      toast.error(response.data.message);
    }
  } catch (error) {
    toast.error('Error registration');
    console.error(error);
  }
};
</script>

<style scoped>
</style>
