"use strict";
jQuery(document).ready(function ($) {
    //==========================================
    // Preloader (Fix loading screen)
    //==========================================
    $(window).on("load", function () {
        $("#loading").fadeOut(500, function () {
            $("body").css("overflow", "auto");
        });

        // ✅ Bootstrap Carousel (Autoplay)
        new bootstrap.Carousel(document.getElementById("carousel"), {
            interval: 4000,
            ride: "carousel"
        });
    });

    //==========================================
    // ScrollUp
    //==========================================
    $(window).scroll(function () {
        if ($(this).scrollTop() > 600) {
            $("#scrollUp").fadeIn("slow");
        } else {
            $("#scrollUp").fadeOut("slow");
        }
    });

    $("#scrollUp").click(function () {
        $("html, body").animate({ scrollTop: 0 }, 1000);
        return false;
    });

    //==========================================
    // Fancybox
    //==========================================
    $(".fancybox").fancybox();

    //==========================================
    // Review Form Submission
    //==========================================
    const form = document.getElementById("review-form");
    const formStatus = document.getElementById("form-status");
    const reviewsList = document.getElementById("reviews-list");

    form.addEventListener("submit", function (e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch("submit_review.php", {
            method: "POST",
            body: formData
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    form.reset();
                    formStatus.textContent = "✅ Review submitted successfully!";
                    formStatus.style.color = "lime";
                    loadReviews();
                    setTimeout(() => {
                        formStatus.textContent = "";
                    }, 3000);
                } else {
                    formStatus.textContent = "❌ " + (data.error || "Something went wrong.");
                    formStatus.style.color = "red";
                }
            })
            .catch((err) => {
                console.error(err);
                formStatus.textContent = "❌ Submission failed. Please try again.";
                formStatus.style.color = "red";
            });
    });

    function loadReviews() {
        fetch("get_reviews.php")
            .then((res) => res.text())
            .then((html) => {
                reviewsList.innerHTML = html;
            });
    }

    loadReviews(); // Load reviews on page load
});




document.getElementById("review-form").addEventListener("submit", function(event){
    event.preventDefault();
    
    // Disable the button to prevent multiple clicks
    let submitButton = document.querySelector("button[type='submit']");
    submitButton.disabled = true;

    let formData = new FormData(this);

    // Assuming you're using AJAX to send the form data to your PHP file
    fetch('submit_review.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            alert('Review submitted successfully');
        } else {
            alert('Error submitting review');
        }
        // Re-enable the button in case of error or success
        submitButton.disabled = false;
    })
    .catch(error => {
        console.error('Error:', error);
        submitButton.disabled = false;
    });
});
