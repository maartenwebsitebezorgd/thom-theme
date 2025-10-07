/**
 * Articles Grid - Dynamic Team Card
 * Shows team member author when hovering over articles with smooth transitions
 */

export default function articlesGridTeamCard() {
  const grids = document.querySelectorAll('[data-articles-grid]');

  grids.forEach((grid) => {
    const articleCards = grid.querySelectorAll('[data-article-card]');
    const teamCardContainer = grid.querySelector('[data-team-card-container]');

    if (!teamCardContainer) return;

    const teamMemberCards = teamCardContainer.querySelectorAll('[data-team-member-card]');
    let currentTeamMemberId = null;
    let isTransitioning = false;

    // Add CSS for smooth transitions
    teamMemberCards.forEach((card) => {
      card.style.transition = 'opacity 0.3s ease-in-out, transform 0.3s ease-in-out';
      card.style.position = 'absolute';
      card.style.width = '100%';
      card.style.top = '0';
      card.style.left = '0';
    });

    // Set container position relative
    teamCardContainer.style.position = 'relative';

    // Function to show specific team member card with transition
    const showTeamMember = (teamMemberId) => {
      if (!teamMemberId || teamMemberId === currentTeamMemberId || isTransitioning) return;

      isTransitioning = true;
      const newCard = Array.from(teamMemberCards).find(
        (card) => card.dataset.teamMemberCard === teamMemberId
      );
      const currentCard = Array.from(teamMemberCards).find(
        (card) => card.dataset.teamMemberCard === currentTeamMemberId
      );

      if (!newCard) {
        isTransitioning = false;
        return;
      }

      // Fade out current card
      if (currentCard) {
        currentCard.style.opacity = '0';
        currentCard.style.transform = 'translateY(-10px)';
      }

      // Show and fade in new card
      setTimeout(() => {
        teamMemberCards.forEach((card) => {
          if (card.dataset.teamMemberCard === teamMemberId) {
            card.classList.remove('hidden');
            card.style.opacity = '0';
            card.style.transform = 'translateY(10px)';

            // Trigger reflow
            card.offsetHeight;

            // Fade in
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
          } else {
            card.classList.add('hidden');
          }
        });

        currentTeamMemberId = teamMemberId;

        setTimeout(() => {
          isTransitioning = false;
        }, 300);
      }, currentCard ? 300 : 0);
    };

    // Initialize first card
    if (teamMemberCards.length > 0) {
      const firstCard = teamMemberCards[0];
      currentTeamMemberId = firstCard.dataset.teamMemberCard;
      firstCard.style.opacity = '1';
      firstCard.style.transform = 'translateY(0)';

      // Set initial height based on first card
      const updateHeight = () => {
        const visibleCard = Array.from(teamMemberCards).find(
          (card) => !card.classList.contains('hidden')
        );
        if (visibleCard) {
          teamCardContainer.style.height = `${visibleCard.offsetHeight}px`;
        }
      };
      updateHeight();

      // Update height on window resize
      window.addEventListener('resize', updateHeight);
    }

    // Add hover listeners to article cards
    articleCards.forEach((articleCard) => {
      articleCard.addEventListener('mouseenter', () => {
        const teamMemberId = articleCard.dataset.teamMemberId;
        if (teamMemberId) {
          showTeamMember(teamMemberId);
        }
      });
    });
  });
}
