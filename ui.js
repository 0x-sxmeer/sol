document.addEventListener('DOMContentLoaded', () => {
    // ----------------------------------------------------
    // 1. Tab Switching Logic
    // ----------------------------------------------------
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active class from all
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));

            // Add active class to clicked
            btn.classList.add('active');
            
            // Show corresponding content
            const targetId = btn.getAttribute('data-tab');
            const targetContent = document.getElementById(targetId);
            if (targetContent) {
                targetContent.classList.add('active');
            }
        });
    });

    // ----------------------------------------------------
    // 2. Button Logic (Making them "Workable")
    // ----------------------------------------------------
    
    // -- "Join Discord" Button --
    const discordBtn = document.querySelector('.participation-funnel .glass-card:nth-child(1) .btn-primary');
    if(discordBtn) {
        discordBtn.addEventListener('click', () => {
            // Placeholder: Simulate web link opening
            window.open('https://discord.gg/huddle01', '_blank'); // Using a likely Discord link
        });
    }

    // -- "Submit" Email Button --
    const emailInput = document.querySelector('.input-field');
    const submitBtn = document.querySelector('.input-group .btn-primary');
    
    if(submitBtn && emailInput) {
        submitBtn.addEventListener('click', () => {
            const email = emailInput.value.trim();
            if(email && email.includes('@')) {
                // Determine Success
                showToast('Success!', 'You have been added to the whitelist.', 'success');
                emailInput.value = ''; // Clear input
                submitBtn.textContent = 'Subscribed';
                submitBtn.disabled = true;
                setTimeout(() => {
                   submitBtn.textContent = 'Submit';
                   submitBtn.disabled = false;
                }, 3000);
            } else {
                // Determine Error
                showToast('Error', 'Please enter a valid email address.', 'error');
            }
        });
    }

    // -- "Connect Wallet" Secondary Button --
    const secondaryConnectBtn = document.getElementById('secondary-connect-btn');
    if(secondaryConnectBtn) {
        secondaryConnectBtn.addEventListener('click', () => {
            // Find the main Connect Wallet button in the navbar (the one with the preserved classes)
            // Note: We used innerText or partial class selection if the class is weird, 
            // but here we know the specific class 'btANoAH_'.
            const mainConnectBtn = document.querySelector('.btANoAH_');
            
            if(mainConnectBtn) {
                // Programmatically click the main button to trigger the original script logic
                mainConnectBtn.click();
                showToast('Info', 'Connecting to wallet...', 'info');
            } else {
                console.error('Main connect button not found!');
                showToast('Error', 'Could not initiate connection.', 'error');
            }
        });
    }

    // ----------------------------------------------------
    // 3. Helper Functions
    // ----------------------------------------------------
    
    // Create and append a toast notification
    function showToast(title, message, type = 'success') {
        // Remove existing toast if any
        const existing = document.querySelector('.toast');
        if(existing) existing.remove();

        const toast = document.createElement('div');
        toast.className = 'toast';
        
        let icon = '✅';
        if(type === 'error') icon = '❌';
        if(type === 'info') icon = 'ℹ️';

        toast.innerHTML = `
            <span style="font-size: 1.2rem;">${icon}</span>
            <div>
                <div style="font-weight: 700; font-size: 0.9rem;">${title}</div>
                <div style="font-size: 0.85rem; opacity: 0.9;">${message}</div>
            </div>
        `;

        document.body.appendChild(toast);

        // Trigger animation
        requestAnimationFrame(() => {
            toast.classList.add('show');
        });

        // Auto remove
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 400); 
        }, 3000);
    }
});
