import { computed, isRef } from "vue";                  // You can use computed property anywhere since they are just javascript functions that offers reactivity

export const useMonthlyPayment = (total, interestRate, duration) => {   // Using composable

    const monthlyPayment = computed(() => {
        const principle = isRef(total) ? total.value : total    // Using isRef is a good practice to check reactivity of variables
        const monthlyInterest = (isRef(interestRate) ? interestRate.value : interestRate) / 100 / 12
        const numberOfPaymentMonths = (isRef(duration) ? duration.value : duration) * 12

        return principle * monthlyInterest * (Math.pow(1 + monthlyInterest, numberOfPaymentMonths)) / (Math.pow(1 + monthlyInterest, numberOfPaymentMonths) - 1)
    })

    const totalPaid = computed(() => {             // Adding more composable members
        return (isRef(duration) ? duration.value : duration) * 12 * monthlyPayment.value
    })

    const totalInterest = computed(() => {          // Adding more composable members
      return (totalPaid.value - (isRef(total) ? total.value : total))
    })
    return { monthlyPayment, totalPaid, totalInterest }                   // Returned as an object (typically, but you can return functions, computed properties, refs)
}
